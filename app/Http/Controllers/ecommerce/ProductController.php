<?php

namespace App\Http\Controllers\ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ecommerce\Product;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
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
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
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

  /**
   * Get all products in database without SEO URL, format the name to use as
   * a friendly URL and insert in database.
   */
  public function ocConvertNameToFriendlyUrl() {
    $productsNotIncluded = [];

    $products = DB::connection("loja")
    ->table("oc_product_description")
    ->join("oc_product", "oc_product_description.product_id", "=", "oc_product.product_id")
    ->select("oc_product_description.product_id", "name")
    ->whereNotIn(
      DB::raw("CONCAT(\"product_id=\", oc_product_description.product_id)"),
      function ($query) {
        $query->select("query")
        ->from("oc_seo_url")
        ->whereNotNull("query");
    })->get();
    
    foreach ($products as $key => &$product) {
      // Replaces all letter to lowecase and remove spaces from start/end if have
      $product->seo_url = trim(strtolower($product->name));
      // Replaces spaces per hyphens
      $product->seo_url = str_replace(" ", "-", $product->seo_url);
      // Remove all accents
      $product->seo_url = $this->cleanAccents($product->seo_url);
      // Replaces multiple hyphens with single one.
      $product->seo_url = preg_replace("/-+/", "-", $product->seo_url);

      // Check if friendly URL exists, if not make the insert on DB.
      $keywordExists = DB::connection("loja")
      ->table("oc_seo_url")
      ->select("keyword")
      ->where("keyword", $product->seo_url)
      ->exists();

      if (!$keywordExists) {
        DB::transaction(function () use ($product) {
          DB::connection("loja")
          ->table("oc_seo_url")
          ->insert([
            "store_id" => 0,
            "language_id" => 2,
            "query" => "product_id={$product->product_id}",
            "keyword" => $product->seo_url
          ]);
        });
      } else {
        $productsNotIncluded[] = $product;
      }

      unset($keywordExists);
    }

    dd($productsNotIncluded);
  }

  private function cleanAccents($text) {
    $utf8 = array(
      "/[áàâãªä]/u"   =>   "a",
      "/[ÁÀÂÃÄ]/u"    =>   "A",
      "/[ÍÌÎÏ]/u"     =>   "I",
      "/[íìîï]/u"     =>   "i",
      "/[éèêë]/u"     =>   "e",
      "/[ÉÈÊË]/u"     =>   "E",
      "/[óòôõºö]/u"   =>   "o",
      "/[ÓÒÔÕÖ]/u"    =>   "O",
      "/[úùûü]/u"     =>   "u",
      "/[ÚÙÛÜ]/u"     =>   "U",
      "/ç/"           =>   "c",
      "/Ç/"           =>   "C",
      "/ñ/"           =>   "n",
      "/Ñ/"           =>   "N",
      "/–/"           =>   "-", // UTF-8 hyphen to "normal" hyphen
      "/[’‘‹›‚]/u"    =>   " ", // Literally a single quote
      "/[“”«»„]/u"    =>   " ", // Double quote
      "/ /"           =>   " ", // nonbreaking space (equiv. to 0x160)
    );

    return preg_replace(array_keys($utf8), array_values($utf8), $text);
  }
}
