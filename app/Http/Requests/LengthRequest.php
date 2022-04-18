<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LengthRequest extends FormRequest
{
    /**
     * Tabela/Model do form request.
     *
     * @var string
     */
    private string $table = 'App\Models\Length';

    /**
     * Tabela/Model dos campos de descrição do form request.
     *
     * @var string
     */
    private string $tableDescription = 'App\Models\LengthDescription';

    /**
     * Verifica se o usuário está autorizado a fazer esse request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Pega as regras de validação a serem aplicadas no request.
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
            'length' => 'required|array',
            'length.value' => implode('|', $rules['value']),
            'length.descriptions' => 'required|array',
            'length.descriptions.*.language_id' => implode('|', $rules['language_id']),
            'length.descriptions.*.name' => implode('|', $rules['name']),
            'length.descriptions.*.unit' => implode('|', $rules['unit']),
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
            'length' => 'required|array',
            'length.id' => implode('|', $rules['id']),
            'length.value' => implode('|', $rules['value']),
            'length.descriptions' => 'nullable|array',
            'length.descriptions.*.id' => implode('|', $rules['description_id']),
            'length.descriptions.*.language_id' => implode('|', $rules['language_id']),
            'length.descriptions.*.name' => implode('|', $rules['name']),
            'length.descriptions.*.unit' => implode('|', $rules['unit']),
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
            'length' => __('length.attributes.length'),
            'length.id' => __('length.attributes.id'),
            'length.value' => __('length.attributes.value'),
            'length.descriptions' => __('length.attributes.descriptions'),
            'length.descriptions.*.id' => __('length.attributes.description.id'),
            'length.descriptions.*.language_id' => __('length.attributes.description.language_id'),
            'length.descriptions.*.name' => __('length.attributes.description.name'),
            'length.descriptions.*.unit' => __('length.attributes.description.unit'),
        ];
    }
}
