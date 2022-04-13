<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\QueryRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
  /**
   * Lista os produtos com ou sem parâmetros.
   *
   * @param \App\Http\Requests\QueryRequest
   * @return \Illuminate\Http\Response
   */
  public function index(QueryRequest $request)
  {
    $products = new Product();
    $params = $request->safe()->all();

    $products = $products->select(
      'products.id',
      'product_descriptions.name',
      'isbn13',
      DB::Raw('(
        SELECT price
        FROM stocks
        WHERE product_id = products.id
        ORDER BY stocks.id
        DESC LIMIT 1
      ) AS price'),
      DB::Raw('(SUM(quantity) - SUM(quantity_sold)) as quantity'),
      'status'
    )->join(
      'product_descriptions',
      'product_descriptions.product_id',
      'products.id'
    )->join('stocks', 'stocks.product_id', 'products.id');

    if (
      isset($params['status']) &&
      ($params['status'] >= 0 && $params['status'] <= 1)
    ) {
      $products = $products->where('status', '=', $params['status']);
    }

    if (isset($params['search'])) {
      $products = $products->where(function ($query) use ($params) {
        $query->orWhere('isbn13', 'like', "%{$params['search']}%");
        $query->orWhere('name', 'like', "%{$params['search']}%");
      });
    }

    $products->groupBy(
      'products.id',
      'product_descriptions.name',
      'isbn13',
      'status'
    );

    if (isset($params['limit']) && $params['limit'] > 0) {
      $productsResult = $products->paginate($params['limit']);
    } else {
      $productsResult = $products->get();
    }


    return response()->json($productsResult);
  }

  /**
   * Salva um novo produto no banco de dados.
   *
   * @param  \App\Http\Requests\ProductRequest  $productRequest
   * @return \Illuminate\Http\Response
   */
  public function store(ProductRequest $productRequest)
  {
    $product = $productRequest->safe()->all()['product'];

    if (
      !isset($product['data']) ||
      !isset($product['descriptions']) ||
      !isset($product['seo']) ||
      !isset($product['stock'])
    ) {
      return response()->json([
        'status' => 500,
        'message' => __('validation.set_all_required')
      ], 500);
    }

    $newProduct = DB::transaction(function () use ($product) {
      $newProduct = Product::create($product['data']);
      $newProduct->description()->createMany($product['descriptions']);
      $newProduct->seo()->createMany($product['seo']);
      $newProduct->stock()->createMany($product['stock']);

      return $newProduct;
    }, 5);

    return response()->json($newProduct->id);
  }

  /**
   * Retorna um produto pelo ID
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return response()->json(
      Product::with('description')
        ->with('seo')
        ->with('stock')
        ->find($id)
    );
  }

  /**
   * Atualiza um produto no banco de dados.
   * 
   * //TODO: fazer com que ele crie as novas descrições, seos e estoque.
   * Por enquanto ele apenas salva as já existentes.
   *
   * @param  \App\Http\Requests\ProductRequest  $productRequest
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(ProductRequest $productRequest, $id)
  {
    $changedProduct = $productRequest->safe()->all()['product'];
    $relationships = [];

    // Dados
    try {
      $product = Product::findOrFail($id);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'status' => 400,
        'message' => "O produto de ID {$id} não foi encontrado.",
      ], 400);
    }

    $product->fill($changedProduct['data']);

    // Descrições
    foreach ($changedProduct['descriptions'] as $value) {
      try {
        $description = $product->description()->where('product_id', $id)
          ->where('language_id', $value['language_id'])->firstOrFail();
      } catch (ModelNotFoundException $e) {
        return response()->json([
          'status' => 400,
          'message' => "A descrição do idioma de ID {$value['language_id']} não foi encontrada."
        ], 400);
      }

      $description->fill($value);
      $relationships[] = $description;
    }

    // SEO
    foreach ($changedProduct['seo'] as $value) {
      try {
        $seo = $product->seo()->where('language_id', $value['language_id'])->firstOrFail();
      } catch (ModelNotFoundException $e) {
        return response()->json([
          'status' => 400,
          'message' => "O SEO do idioma de ID {$value['language_id']} não foi encontrado."
        ], 400);
      }

      $seo->fill($value);
      $relationships[] = $seo;
    }

    // Stock
    foreach ($changedProduct['stock'] as $value) {
      try {
        $stock = $product->stock()->where('id', $value['id'])->firstOrFail();
      } catch (ModelNotFoundException $e) {
        return response()->json([
          'status' => 400,
          'message' => "O estoque de ID {$value['id']} não foi encontrado."
        ]);
      }

      $stock->fill($value);
      $relationships[] = $stock;
    }

    $teste = DB::transaction(function () use ($product, $relationships) {
      foreach ($relationships as $relationship) {
        $relationship->save();
      }

      return $product->save();
    }, 5);


    return response()->json([
      'id' => $id,
      'result' => $teste,
      'product' => $product,
      'data' => $productRequest->safe()->all()
    ]);
  }

  /**
   * Remove um produto do banco de dados utilizando o soft delete.
   * Se o parâmetro "$force" for verdadeiro, o item será removido
   * completamente do banco de dados.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id, $force = false)
  {
    try {
      if (!$force) {
        $product = Product::findOrFail($id);
        $method = 'delete';
        $message = __('product.softdeleted', ['id' => $id]);
      } else {
        $product = Product::withTrashed()->findOrFail($id);
        $method = 'forceDelete';
        $message = __('product.deleted', ['id' => $id]);
      }

      DB::transaction(function () use ($product, $method) {
        $product->stock()->$method();
        $product->seo()->$method();
        $product->description()->$method();
        $product->$method();
      }, 5);

      return response([
        'status' => 200,
        'message' => $message
      ], Response::HTTP_OK);
    } catch (ModelNotFoundException $ex) {
      return response([
        'status' => 404,
        'message' => __('product.not_found', ['id' => $id]),
        'data' => $ex
      ], Response::HTTP_NOT_FOUND);
    } catch (\Exception $ex) {
      return response([
        'status' => 500,
        'message' => __('general.unknown_error'),
        'data' => $ex
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
