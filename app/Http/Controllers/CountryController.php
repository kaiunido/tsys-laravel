<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use App\Http\Requests\CountryRequest;
use App\Models\Country;

class CountryController extends Controller
{
  /**
   * Retorna uma lista de países de acordo com os parâmetros.
   *
   * @return JsonResponse
   */
  public function index(): JsonResponse
  {
    return response()->json(Country::all());
  }

  /**
   * Cria um novo país no banco de dados.
   *
   * @param CountryRequest $request
   * @return JsonResponse
   */
  public function store(CountryRequest $request): JsonResponse
  {
    try {
      $country = DB::transaction(function () use ($request) {
        return Country::create($request->safe()->all()['country']);
      }, 5);

      return response()->json([
        'status' => 200,
        'data' => ['id' => $country->id]
      ]);
    } catch (Throwable) {
      return response()->json([
        'status' => 500,
        'message' => __('general.unknown_error'),
      ], 500);
    }
  }

  /**
   * Retorna um país pelo ID.
   *
   * @param int $id
   * @return JsonResponse
   */
  public function show(int $id): JsonResponse
  {
    try {
      $country = (new Country)->findOrFail($id);

      return response()->json([
        'status' => 200,
        'data' => $country
      ]);
    } catch (ModelNotFoundException) {
      return response()->json([
        'status' => 400,
        'message' => 'Não foi possível encontrar um país com o ID ' . $id . '.'
      ], 400);
    }
  }

  /**
   * Atualiza um país existente no banco de dados através do ID.
   *
   * @param Request $request
   * @param int $id
   * @return void
   */
  public function update(Request $request, int $id)
  {
    //
  }

  /**
   * Faz o soft delete de um país ou remove completamente ao utilizar o
   * parâmetro "$force" como verdadeiro.
   *
   * @param int $id
   * @return void
   */
  public function destroy(int $id)
  {
    //
  }
}
