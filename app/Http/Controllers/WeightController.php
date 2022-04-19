<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeightRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Models\Weight;
use Illuminate\Support\Facades\DB;
use Throwable;

class WeightController extends Controller
{
    /**
     * Retorna todos as unidades de peso.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $weightUnit = Weight::with('descriptions')->get();

        return response()->json([
            'status' => '200',
            'data' => $weightUnit
        ]);
    }

    /**
     * Armazena uma nova unidade de peso.
     *
     * @param WeightRequest $request
     * @return JsonResponse
     */
    public function store(WeightRequest $request): JsonResponse
    {
        try {
            $data = $request->safe()->all()['weight'];
            $descriptions = $data['descriptions'];
            unset($data['descriptions']);

            $newWeight = DB::transaction(function () use ($data, $descriptions) {
                $newWeight = Weight::create($data);
                $newWeight->descriptions()->createMany($descriptions);
                return $newWeight;
            }, 5);

            return response()->json([
                'status' => '200',
                'data' => ['id' => $newWeight->id],
            ]);
        } catch (Throwable) {
            return response()->json([
                'status' => '500',
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }

    /**
     * Retorna uma unidade de peso pelo ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $weightUnit = Weight::with('descriptions')->findOrFail($id);

            return response()->json([
                'status' => '200',
                'data' => $weightUnit,
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => '400',
                'message' => __('weight.not_found', ['id' => $id]),
            ], 400);
        } catch (Throwable) {
            return response()->json([
                'status' => '500',
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }

    /**
     * Atualiza uma unidade de peso.
     *
     * @param WeightRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(WeightRequest $request, int $id): JsonResponse
    {
        try {
            /** @var Weight $weightUnit */
            $weightUnit = Weight::with('descriptions')->findOrFail($id);
            $data = $request->safe()->all()['weight'];
            $descriptions = [];

            if (isset($data['descriptions'])) {
                foreach ($data['descriptions'] as $description) {
                    $result = $weightUnit->descriptions()->findOrFail($description['id']);
                    $result->fill($description);
                    $descriptions[] = $result;
                }

                unset($data['descriptions']);
            }

            $weightUnit->fill($data);

            DB::transaction(function () use ($weightUnit, $descriptions) {
                foreach ($descriptions as $description) {
                    $description->save();
                }

                $weightUnit->save();
            }, 5);

            return response()->json([
                'status' => '200',
                'message' => __('weight.updated', ['id' => $id]),
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => '400',
                'message' => __('weight.not_found', ['id' => $id]),
            ], 400);
        } catch (Throwable $e) {
            return response()->json([
                'status' => '500',
                'message' => __('general.unknown_error'),
                'data' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove uma unidade de peso utilizando soft-delete ou permanentemente
     * se $force for verdadeiro.
     *
     * @param int $id
     * @param bool $force
     * @return JsonResponse
     */
    public function destroy(int $id, bool $force = false): JsonResponse
    {
        try {
            $status = DB::transaction(function () use ($id, $force) {
                if ($force) {
                    $weightUnit = Weight::withTrashed()->findOrFail($id);
                    return $weightUnit->forceDelete();
                } else {
                    $weightUnit = Weight::findOrFail($id);
                    return $weightUnit->delete();
                }
            }, 5);

            if ($status) {
                return response()->json([
                    'status' => '200',
                    'message' => __('weight.deleted', ['id' => $id]),
                ]);
            } else {
                return response()->json([
                    'status' => '500',
                    'message' => __('general.unknown_error'),
                ], 500);
            }
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => '400',
                'message' => __('weight.not_found', ['id' => $id]),
            ], 400);
        } catch (Throwable) {
            return response()->json([
                'status' => '500',
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }
}
