<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightRequest extends FormRequest
{
    /**
     * Tabela/Model do form request.
     *
     * @var string
     */
    private string $table = 'App\Models\Weight';

    /**
     * Tabela/Model dos campos de descrição do form request.
     *
     * @var string
     */
    private string $tableDescription = 'App\Models\WeightDescription';

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->method() === 'PATCH' ? $this->updateRules() : $this->storeRules();
    }

    /**
     * Retorna as regras de validação para o store.
     *
     * @return array
     */
    private function storeRules(): array
    {
        $rules = [
            'value' => [
                'required',
                'numeric',
            ],
            'language_id' => [
                'required',
                'integer',
                'exists:App\Models\Language,id'
            ],
            'name' => [
                'required',
                'string',
                "unique:$this->tableDescription,name,NULL,NULL,language_id,value,deleted_at,NULL"
            ],
            'unit' => [
                'required',
                'string',
                'max:3',
                "unique:$this->tableDescription,unit,NULL,NULL,language_id,value,deleted_at,NULL"
            ]
        ];

        return [
            'weight' => 'required|array',
            'weight.value' => implode('|', $rules['value']),
            'weight.descriptions' => 'required|array',
            'weight.descriptions.*.language_id' => implode('|', $rules['language_id']),
            'weight.descriptions.*.name' => implode('|', $rules['name']),
            'weight.descriptions.*.unit' => implode('|', $rules['unit']),
        ];
    }

    /**
     * Retorna as regras de validação para o update.
     *
     * @return array
     */
    private function updateRules(): array
    {
        $rules = [
            'id' => [
                'required',
                'integer',
                "exists:$this->table,id,deleted_at,NULL"
            ],
            'value' => [
                'numeric',
            ],
            'description_id' => [
                'required',
                'integer',
                "exists:$this->tableDescription,id,deleted_at,NULL"
            ],
            'language_id' => [
                'integer',
                'exists:App\Models\Language,id'
            ],
            'name' => [
                'string',
                "unique:$this->tableDescription,name,{$this->route('length')},id,language_id,value,deleted_at,NULL"
            ],
            'unit' => [
                'string',
                'max:3',
                "unique:$this->tableDescription,unit,{$this->route('length')},id,language_id,value,deleted_at,NULL"
            ]
        ];

        return [
            'weight' => 'required|array',
            'weight.id' => implode('|', $rules['id']),
            'weight.value' => implode('|', $rules['value']),
            'weight.descriptions' => 'nullable|array',
            'weight.descriptions.*.id' => implode('|', $rules['description_id']),
            'weight.descriptions.*.language_id' => implode('|', $rules['language_id']),
            'weight.descriptions.*.name' => implode('|', $rules['name']),
            'weight.descriptions.*.unit' => implode('|', $rules['unit']),
        ];
    }

    /**
     * Passa a tradução do nome dos campos para as mensagens de erro.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'weight' => __('weight.attributes.weight'),
            'weight.id' => __('weight.attributes.id'),
            'weight.value' => __('weight.attributes.value'),
            'weight.descriptions' => __('weight.attributes.descriptions'),
            'weight.descriptions.*.id' => __('weight.attributes.description.id'),
            'weight.descriptions.*.language_id' => __('weight.attributes.description.language_id'),
            'weight.descriptions.*.name' => __('weight.attributes.description.name'),
            'weight.descriptions.*.unit' => __('weight.attributes.description.unit'),
        ];
    }
}
