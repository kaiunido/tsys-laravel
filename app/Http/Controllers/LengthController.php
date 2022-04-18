<?php

namespace App\Http\Controllers;

use App\Models\Length;
use App\Http\Requests\LengthRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use Illuminate\Http\JsonResponse;

class LengthController extends Controller
{
    /**
     * Retorna todas as unidades de medida.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $lengthUnits = Length::with('descriptions')->get();

        return response()->json([
            'status' => '200',
            'data' => $lengthUnits,
        ]);
    }

    /**
     * Cadastra uma nova unidade de medida.
     *
     * @param LengthRequest $request
     * @return JsonResponse
     */
    public function store(LengthRequest $request): JsonResponse
    {
        try {
            $data = $request->safe()->all()['length'];
            $descriptions = $data['descriptions'];
            unset($data['descriptions']);

            $newLength = DB::transaction(function () use ($data, $descriptions) {
                $newLength = Length::create($data);
                $newLength->descriptions()->createMany($descriptions);
                return $newLength;
            }, 5);

            return response()->json([
                'status' => '200',
                'data' => ['id' => $newLength->id],
            ]);
        } catch (Throwable) {
            return response()->json([
                'status' => '500',
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }

    /**
     * Retorna uma unidade de medida pelo ‘id’.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $lengthUnit = Length::with('descriptions')->findOrFail($id);

            return response()->json([
                'status' => '200',
                'data' => $lengthUnit,
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => '400',
                'message' => __('length.not_found', ['id' => $id]),
            ], 400);
        } catch (Throwable) {
            return response()->json([
                'status' => '500',
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }

    /**
     * Atualiza uma unidade de medida.
     *
     * @param LengthRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(LengthRequest $request, int $id): JsonResponse
    {
        try {
            /** @var Length $length */
            $length = Length::with('descriptions')->findOrFail($id);
            $data = $request->safe()->all()['length'];
            $descriptions = [];

            if (isset($data['descriptions'])) {
                foreach ($data['descriptions'] as $description) {
                    $result = $length->descriptions()->findOrFail($description['id']);
                    $result->fill($description);
                    $descriptions[] = $result;
                }

                unset($data['descriptions']);
            }

            $length->fill($data);

            DB::transaction(function () use ($length, $descriptions) {
                foreach ($descriptions as $description) {
                    $description->save();
                }

                $length->save();
            }, 5);

            return response()->json([
                'status' => '200',
                'message' => __('length.updated', ['id' => $id]),
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => '400',
                'message' => __('length.not_found', ['id' => $id]),
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
     * Remove utilizando o ‘soft-delete’ uma unidade de medida, caso $force for
     * verdadeiro irá remover permanentemente.
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
                    $lengthUnit = Length::withTrashed()->with('descriptions')->findOrFail($id);
                    return $lengthUnit->forceDelete();
                } else {
                    $lengthUnit = Length::with('descriptions')->findOrFail($id);
                    return $lengthUnit->delete();
                }
            }, 5);

            if ($status) {
                return response()->json([
                    'status' => '200',
                    'message' => __('length.deleted'),
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
                'message' => __('length.not_found', ['id' => $id]),
            ], 400);
        } catch (Throwable $e) {
            return response()->json([
                'status' => '500',
                'message' => __('general.unknown_error'),
                'data' => $e
            ], 500);
        }
    }
}
