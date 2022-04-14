<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use App\Http\Requests\CountryRequest;
use App\Models\Country;

class CountryController extends Controller
{
    /**
     * Retorna uma lista de países conforme os parâmetros.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Country::all());
    }

    /**
     * Cria um país no banco de dados.
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
                'message' => __('country.not_found', ['id' => $id])
            ], 400);
        }
    }

    /**
     * Atualiza um país existente no banco de dados através do ID.
     *
     * @param CountryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CountryRequest $request, int $id): JsonResponse
    {
        try {
            $country = Country::findOrFail($id);
            $country->fill($request['country']);

            $savedCountry = DB::transaction(function () use ($country) {
                return $country->save();
            });

            return response()->json([
                'status' => 200,
                'message' => __('country.updated', ['id' => $id]),
                'data' => $savedCountry,
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => 400,
                'message' => __('country.not_found', ['id' => $id]),
            ], 400);
        } catch (Throwable) {
            return response()->json([
                'status' => 500,
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }

    /**
     * Faz o "soft-delete" de um país ou remove completamente ao utilizar o
     * parâmetro "$force" como verdadeiro.
     *
     * @param int $id
     * @param bool $force
     * @return JsonResponse
     */
    public function destroy(int $id, bool $force = false): JsonResponse
    {
        try {
            $country = Country::findOrFail($id);

            $countryDeleted = DB::transaction(function () use ($country, $force) {
                if (!$force) {
                    return $country->delete();
                } else {
                    return $country->forceDelete();
                }
            });

            return response()->json([
                'status' => 200,
                'message' => __('country.deleted', ['id' => $id]),
                'data' => $countryDeleted
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => 400,
                'message' => __('country.not_found', ['id' => $id])
            ], 400);
        } catch (Throwable) {
            return response()->json([
                'status' => 500,
                'message' => __('general.unknown_error')
            ], 500);
        }
    }
}
