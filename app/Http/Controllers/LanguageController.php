<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class LanguageController extends Controller
{
    /**
     * Retorna todos os idiomas
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $languages = Language::all();

        return response()->json($languages);
    }

    /**
     * Cadastra um novo idioma no banco de dados.
     *
     * @param  LanguageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        try {
            $language = Language::create($request->safe()->all()['language']);

            return response()->json($language->id);
        } catch (Throwable) {
            return response()->json([
                'status' => 500,
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }

    /**
     * Retorna um idioma de acordo com o ID.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $language = Language::findOrFail($id);

            return response()->json($language);
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => 400,
                'message' => "O idioma de ID {$id} não foi encontrado.",
            ], 400);
        } catch (Throwable) {
            return response()->json([
                'status' => 500,
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }

    /**
     * Atualiza um idioma no banco de dados.
     *
     * @param  LanguageRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(LanguageRequest $request, int $id): JsonResponse
    {
        if (!$request->safe()->all() && !$request->safe()->all()) {
            return response()->json([
                'status' => 400,
                'message' => __('general.no_data'),
            ]);
        }

        try {
            $language = Language::findOrFail($id);

            $language->fill($request->safe()->all()['language']);
            $status = $language->save();

            if ($status) {
                return response()->json([
                    'status' => 200,
                    'message' => __('language.updated', ['id' => $id]),
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'general.unknown_error'
                ], 500);
            }
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => 400,
                'message' => __('language.not_found'),
            ], 400);
        } catch (Throwable) {
            return response()->json([
                'status' => 500,
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }

    /**
     * Faz o "soft-delete" de um idioma ou remove completamente ao utilizar o
     * parâmetro "$force" como verdadeiro.
     *
     * @param  int  $id
     * @param  bool $force
     * @return JsonResponse
     */
    public function destroy(int $id, $force = false): JsonResponse
    {
        try {
            $language = Language::findOrFail($id);

            $status = DB::transaction(function () use ($language, $force) {
                if ($force) {
                    return $language->forceDelete();
                } else {
                    return $language->delete();
                }
            }, 5);

            if ($status) {
                return response()->json([
                    'status' => 200,
                    'message' => __('language.deleted', ['id' => $id]),
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
                'message' => __('language.not_found', ['id' => $id]),
            ], 400);
        } catch (Throwable) {
            return response()->json([
                'status' => 500,
                'message' => __('general.unknown_error'),
            ], 500);
        }
    }
}
