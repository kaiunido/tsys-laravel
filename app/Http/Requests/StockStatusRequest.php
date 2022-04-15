<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockStatusRequest extends FormRequest
{
    /**
     * Tabela ou Model das Situações de Estoque.
     * 
     * @var
     */
    private $table = 'App\Models\StockStatus';

    /**
     * Determina se o usuário está autorizado a fazer o request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Retorna as regras de validação que serão aplicadas ao request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->method() === 'PATCH' ? $this->updateRules() : $this->storeRules();
    }

    /**
     * Retorna as regras de validação que serão aplicadas no store.
     * 
     * @return array
     */
    private function storeRules(): array
    {
        $data = $this->request->all('stock_status');
        $name = isset($data['name']) ? $data['name'] : 'NULL';
        $languageId = isset($data['language_id']) ? $data['language_id'] : 'NULL';

        $rules = [
            'language_id' => [
                'required',
                'integer',
                "unique:{$this->table},language_id,NULL,NULL,name,{$name},deleted_at,NULL",
                'exists:App\Models\Language,id,deleted_at,NULL'
            ],
            'name' => [
                'required',
                'string',
                "unique:{$this->table},name,NULL,NULL,language_id,{$languageId},deleted_at,NULL",
            ],
        ];

        return [
            'stock_status.language_id' => implode('|', $rules['language_id']),
            'stock_status.name' => implode('|', $rules['name']),
        ];
    }

    /**
     * Retorna as regras de validação que serão aplicadas no update.
     * 
     * @return array
     */
    private function updateRules(): array
    {
        //TODO: Pegar a language_id na model pois se a mesma não for enviada é pesquisada como NULL
        // na query:
        // select count(*) as aggregate from `stock_statuses` where `name` = 'Encomenda' and `id` <> '4' and `language_id` is null
        $data = $this->request->all('stock_status');
        $name = isset($data['name']) ? $data['name'] : 'NULL';
        $languageId = isset($data['language_id']) ? $data['language_id'] : 'NULL';

        $rules = [
            'language_id' => [
                'integer',
                "unique:{$this->table},language_id,{$this->route('stockStatus')},id,name,{$name}",
                'exists:App\Models\Language,id,deleted_at,NULL'
            ],
            'name' => [
                'string',
                "unique:{$this->table},name,{$this->route('stockStatus')},id,language_id,{$languageId}",
            ],
        ];

        return [
            'stock_status.language_id' => implode('|', $rules['language_id']),
            'stock_status.name' => implode('|', $rules['name']),
        ];
    }
}
