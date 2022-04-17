<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockStatusRequest;
use App\Models\StockStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class StockStatusController extends Controller
{
    /**
     * Retorna todas as situações de estoque.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $stockStatus = StockStatus::all();

        return response()->json($stockStatus);
    }

    /**
     * Cria uma nova situação de estoque no banco de dados.
     *
     * @param  StockStatusRequest  $request
     * @return JsonResponse
     */
    public function store(StockStatusRequest $request): JsonResponse
    {
        if (!$request->safe()->all()['stock_status']) {
            return response()->json([
                'status' => 400,
                'message' => __('general.no_data'),
            ], 400);
        }

        try {
            $newStockStatus = DB::transaction(function () use ($request) {
                return StockStatus::create($request->safe()->all()['stock_status']);
            }, 5);

            return response()->json([
                'status' => 200,
                'data' => $newStockStatus->id,
            ]);
        } catch (Throwable) {
            return response()->json([
                'status' => 500,
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }

    /**
     * Retorna uma situação de estoque pelo ID.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $stockStatus = StockStatus::findOrFail($id);

            return response()->json($stockStatus);
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => 400,
                'message' => __('stock_status.not_found', ['id' => $id]),
            ], 400);
        } catch (Throwable) {
            return response()->json([
                'status' => 500,
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }

    /**
     * Atualiza uma situação de estoque.
     *
     * @param  StockStatusRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(StockStatusRequest $request, int $id): JsonResponse
    {
        if (!isset($request->safe()->all()['stock_status'])) {
            return response()->json([
                'status' => 400,
                'message' => __('general.no_data'),
            ], 400);
        }

        try {
            $stockStatus = StockStatus::findOrFail($id);
            $stockStatus->fill($request->safe()->all()['stock_status']);

            $result = DB::transaction(function () use ($stockStatus) {
                return $stockStatus->save();
            }, 5);

            if ($result) {
                return response()->json([
                    'status' => 200,
                    'message' => __('stock_status.updated', ['id' => $id]),
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => __('general.unknown_error'),
                ], 500);
            }
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => 400,
                'message' => __('stock_status.not_found', ['id' => $id]),
            ], 400);
        } catch (Throwable) {
            return response()->json([
                'status' => 500,
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }

    /**
     * Remove uma situação de estoque pelo ID utilizando soft-delete ou remove
     * permanentemente se "$force" for verdadeiro.
     *
     * @param  int  $id
     * @param  bool $force
     * @return JsonResponse
     */
    public function destroy(int $id, bool $force = false): JsonResponse
    {
        try {
            $stockStatus = StockStatus::findOrFail($id);

            $result = DB::transaction(function () use ($stockStatus, $force) {
                if ($force) {
                    return $stockStatus->forceDelete();
                } else {
                    return $stockStatus->delete();
                }
            }, 5);

            if ($result) {
                return response()->json([
                    'status' => 200,
                    'message' => __('stock_status.deleted', ['id' => $id]),
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => __('general.unknown_error'),
                ], 500);
            }
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => 400,
                'message' => __('stock_status.not_found', ['id' => $id]),
            ], 400);
        } catch (Throwable) {
            return response()->json([
                'status' => 500,
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }
}
