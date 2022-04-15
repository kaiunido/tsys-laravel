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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'language.name' => "required|string|filled|unique:{$this->table},name",
            'language.code' => "required|string|filled|max:5|unique:{$this->table},code",
            'language.locale' => 'nullable|string|filled|max:5',
            'language.image' => 'nullable|string|filled',
        ];
    }
}
