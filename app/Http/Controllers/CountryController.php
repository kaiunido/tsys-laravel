<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\CountryRequest;
use App\Models\Country;

class CountryController extends Controller
{
  /**
   * Retorna uma lista de países de acordo com os parâmetros.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return response()->json(Country::all());
  }

  /**
   * Cria um novo país no banco de dados.
   *
   * @param  \App\Http\Requests\CountryRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CountryRequest $request)
  {
    try {
      $country = DB::transaction(function () use ($request) {
        return Country::create($request->safe()->all()['country']);
      }, 5);

      return response()->json([
        'status' => 200,
        'data' => ['id' => $country->id]
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 500,
        'message' => __('general.unknown_error'),
      ], 500);
    }
  }

  /**
   * Retorna um país pelo ID.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    try {
      $country = Country::findOrFail($id);

      return response()->json([
        'status' => 200,
        'data' => $country
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'status' => 400,
        'message' => 'Não foi possível encontrar um país com o ID ' . $id . '.'
      ], 400);
    }
  }

  /**
   * Atualiza um país existente no banco de dados através do ID.
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
   * Faz o soft delete de um país ou remove completamente ao utilizar o
   * parâmetro "$force" como verdadeiro.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
