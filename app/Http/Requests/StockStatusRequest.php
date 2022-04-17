<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\StockStatus;
use stdClass;
use Throwable;

class StockStatusRequest extends FormRequest
{
    /**
     * Tabela ou Model das Situações de Estoque.
     *
     * @var string
     */
    private string $table = 'App\Models\StockStatus';

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
        $name = $data['name'] ?? 'NULL';
        $languageId = $data['language_id'] ?? 'NULL';

        $rules = [
            'language_id' => [
                'required',
                'integer',
                "unique:$this->table,language_id,NULL,NULL,name,$name,deleted_at,NULL",
                'exists:App\Models\Language,id,deleted_at,NULL'
            ],
            'name' => [
                'required',
                'string',
                "unique:$this->table,name,NULL,NULL,language_id,$languageId,deleted_at,NULL",
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
        $stockStatus = $this->getStockStatus($this->route('stockStatus'));
        $data = $this->request->all('stock_status');
        $name = $data['name'] ?? $stockStatus->name;
        $languageId = $data['language_id'] ?? $stockStatus->language_id;

        $rules = [
            'language_id' => [
                'integer',
                "unique:$this->table,language_id,{$this->route('stockStatus')},id,name,$name",
                'exists:App\Models\Language,id,deleted_at,NULL'
            ],
            'name' => [
                'string',
                "unique:$this->table,name,{$this->route('stockStatus')},id,language_id,$languageId",
            ],
        ];

        return [
            'stock_status.language_id' => implode('|', $rules['language_id']),
            'stock_status.name' => implode('|', $rules['name']),
        ];
    }

    /**
     * Retorna a situação de estoque pelo ID.
     *
     * @param int $id
     * @return StockStatus|stdClass
     */
    private function getStockStatus(int $id): StockStatus|stdClass
    {
        try {
            return StockStatus::select('language_id', 'name')->findOrFail($id);
        } catch (Throwable) {
            return new stdClass();
        }
    }
}
