<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
      'id',
      'product_descriptions.name',
      'isbn',
      'price',
      'quantity',
      'status'
    )->join('product_descriptions', 'product_id', 'id');

    if ($params['status'] >= 0 && $params['status'] <= 1) {
      $products = $products->where('status', '=', $params['status']);
    }

    if ($params['search']) {
      $products = $products->where(function ($query) use ($params) {
        $query->orWhere('isbn', 'like', "%{$params['search']}%");
        $query->orWhere('name', 'like', "%{$params['search']}%");
      });
    }

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
  public function destroy($id)
  {
    try {
      $deleted = Product::destroy($id);
      return response()->json($deleted);
    } catch (\Throwable $th) {
      return response()->json($th);
    }
  }
}
