<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    /**
     * Model utilizada nas regras
     * 
     * @var string
     */
    private $table = 'App\Models\Country';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Retorna as regras de validação que se aplicam à solicitação.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->method() === 'PATCH' ? $this->updateRules() : $this->storeRules();
    }

    /**
     * Regras de validação para o Store
     * 
     * @return array
     */
    private function storeRules(): array
    {
        return [
            'country.name' => "required|string|unique:{$this->table},name,NULL,NULL,deleted_at,NULL",
            'country.alfa2' => "required|string|size:2|unique:{$this->table},alfa2,NULL,NULL,deleted_at,NULL",
            'country.alfa3' => "required|string|size:3|unique:{$this->table},alfa3,NULL,NULL,deleted_at,NULL"
        ];
    }

    /**
     * Regras de validação para o Update/Patch
     * 
     * @return array
     */
    private function updateRules(): array
    {
        $updated_id = $this->route('country');

        return [
            'country.name' => "string|unique:{$this->table},name,{$updated_id},id,deleted_at,NULL",
            'country.alfa2' => "string|size:2|unique:{$this->table},alfa2,{$updated_id},id,deleted_at,NULL",
            'country.alfa3' => "string|size:3|unique:{$this->table},alfa3,{$updated_id},id,deleted_at,NULL"
        ];
    }
}
