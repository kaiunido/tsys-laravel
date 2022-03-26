<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\QueryRequest;
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
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
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
    //
  }
}
