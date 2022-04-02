<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\QueryRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductDescriptionRequest;
use App\Http\Requests\SeoRequest;
use App\Http\Requests\StockRequest;
use App\Models\Product;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
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
      DB::Raw('(SELECT price FROM stocks WHERE product_id = products.id ORDER BY stocks.id DESC LIMIT 1) AS price'),
      DB::Raw('(SUM(quantity) - SUM(quantity_sold)) as quantity'),
      'status'
    )->join('product_descriptions', 'product_descriptions.product_id', 'products.id')
      ->join('stocks', 'stocks.product_id', 'products.id');

    if ($params['status'] >= 0 && $params['status'] <= 1) {
      $products = $products->where('status', '=', $params['status']);
    }

    if ($params['search']) {
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

    if ($params['limit'] > 0) {
      $productsResult = $products->paginate($params['limit']);
    } else {
      $productsResult = $products->get();
    }


    return response()->json($productsResult);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(
    ProductRequest $productRequest,
    ProductDescriptionRequest $productDescriptionRequest,
    SeoRequest $seoRequest,
    StockRequest $stockRequest
  ) {
    $product = $productRequest->safe()->all()['product'];
    $productDescription = $productDescriptionRequest->safe()->all()['description'];
    $productSeo = $seoRequest->safe()->all()['seo'];
    $productStock = $stockRequest->safe()->all()['stock'];

    $newProduct = DB::transaction(function () use ($product, $productDescription, $productSeo, $productStock) {
      $newProduct = Product::create($product);
      $newProduct->description()->createMany($productDescription);
      $newProduct->seo()->createMany($productSeo);
      $newProduct->stock()->createMany($productStock);

      return $newProduct;
    }, 5);

    return response()->json($newProduct);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return response()->json(Product::with('description')->find($id));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
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
