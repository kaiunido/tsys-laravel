<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
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
     * Store a newly created resource in storage.
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
     * Update the specified resource in storage.
     *
     * @param  LanguageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LanguageRequest $request, $id)
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
