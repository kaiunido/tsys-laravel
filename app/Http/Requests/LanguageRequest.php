<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
    /**
     * Model responsavel pelos requests.
     * 
     * @var $table
     */
    private $table = 'App\Models\Language';

    /**
     * Determina se o usuário está autorizado para fazer a request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Pega as regras de validação para aplica ao request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->method() === 'PATCH' ? $this->updateRules() : $this->storeRules();
    }

    /**
     * Retorna as regras do store
     * 
     * @return array
     */
    private function storeRules(): array
    {
        return [
            'language.name' => "required|string|filled|unique:{$this->table},name,NULL,NULL,deleted_at,NULL",
            'language.code' => "required|string|filled|max:5|unique:{$this->table},code,NULL,NULL,deleted_at,NULL",
            'language.locale' => 'nullable|string|filled|max:5',
            'language.image' => 'nullable|string|filled',
        ];
    }

    /**
     * Retorna as regras do update
     * 
     * @return array
     */
    private function updateRules(): array
    {
        return [
            'language.name' => "nullable|string|filled|unique:{$this->table},name,deleted_at,NULL",
            'language.code' => "nullable|string|filled|max:5|unique:{$this->table},code,deleted_at,NULL",
            'language.locale' => 'nullable|string|filled|max:5',
            'language.image' => 'nullable|string|filled',
        ];
    }
}
