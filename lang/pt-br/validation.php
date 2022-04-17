<?php

return [

  /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

  'accepted' => 'The :attribute must be accepted.',
  'accepted_if' => 'The :attribute must be accepted when :other is :value.',
  'active_url' => 'The :attribute is not a valid URL.',
  'after' => 'The :attribute must be a date after :date.',
  'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
  'alpha' => 'The :attribute must only contain letters.',
  'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
  'alpha_num' => 'The :attribute must only contain letters and numbers.',
  'array' => 'O campo ":attribute" precisa ser um array.',
  'before' => 'The :attribute must be a date before :date.',
  'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
  'between' => [
    'array' => 'The :attribute must have between :min and :max items.',
    'file' => 'The :attribute must be between :min and :max kilobytes.',
    'numeric' => 'The :attribute must be between :min and :max.',
    'string' => 'The :attribute must be between :min and :max characters.',
  ],
  'boolean' => 'O campo :attribute precisa de um valor válido.',
  'confirmed' => 'The :attribute confirmation does not match.',
  'current_password' => 'The password is incorrect.',
  'date' => 'The :attribute is not a valid date.',
  'date_equals' => 'The :attribute must be a date equal to :date.',
  'date_format' => 'The :attribute does not match the format :format.',
  'declined' => 'The :attribute must be declined.',
  'declined_if' => 'The :attribute must be declined when :other is :value.',
  'different' => 'The :attribute and :other must be different.',
  'digits' => 'The :attribute must be :digits digits.',
  'digits_between' => 'The :attribute must be between :min and :max digits.',
  'dimensions' => 'The :attribute has invalid image dimensions.',
  'distinct' => 'The :attribute field has a duplicate value.',
  'email' => 'Por favor preencha um endereço de e-mail válido.',
  'ends_with' => 'The :attribute must end with one of the following: :values.',
  'enum' => 'The selected :attribute is invalid.',
  'exists' => 'O :attribute selecionado é invalido.',
  'file' => 'The :attribute must be a file.',
  'filled' => 'The :attribute field must have a value.',
  'gt' => [
    'array' => 'The :attribute must have more than :value items.',
    'file' => 'The :attribute must be greater than :value kilobytes.',
    'numeric' => 'The :attribute must be greater than :value.',
    'string' => 'The :attribute must be greater than :value characters.',
  ],
  'gte' => [
    'array' => 'The :attribute must have :value items or more.',
    'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
    'numeric' => 'The :attribute must be greater than or equal to :value.',
    'string' => 'The :attribute must be greater than or equal to :value characters.',
  ],
  'image' => 'The :attribute must be an image.',
  'in' => 'The selected :attribute is invalid.',
  'in_array' => 'The :attribute field does not exist in :other.',
  'integer' => 'The :attribute must be an integer.',
  'ip' => 'The :attribute must be a valid IP address.',
  'ipv4' => 'The :attribute must be a valid IPv4 address.',
  'ipv6' => 'The :attribute must be a valid IPv6 address.',
  'json' => 'The :attribute must be a valid JSON string.',
  'lt' => [
    'array' => 'The :attribute must have less than :value items.',
    'file' => 'The :attribute must be less than :value kilobytes.',
    'numeric' => 'The :attribute must be less than :value.',
    'string' => 'The :attribute must be less than :value characters.',
  ],
  'lte' => [
    'array' => 'The :attribute must not have more than :value items.',
    'file' => 'The :attribute must be less than or equal to :value kilobytes.',
    'numeric' => 'The :attribute must be less than or equal to :value.',
    'string' => 'The :attribute must be less than or equal to :value characters.',
  ],
  'mac_address' => 'The :attribute must be a valid MAC address.',
  'max' => [
    'array' => 'O campo :attribute não pode ter mais que :max itens.',
    'file' => 'O arquivo no campo :attribute não pode ser maior que :max kilobytes.',
    'numeric' => 'O campo :attribute não pode ser maior que :max.',
    'string' => 'O campo :attribute não pode ser maior que :max caracteres.',
  ],
  'mimes' => 'The :attribute must be a file of type: :values.',
  'mimetypes' => 'The :attribute must be a file of type: :values.',
  'min' => [
    'array' => 'The :attribute must have at least :min items.',
    'file' => 'The :attribute must be at least :min kilobytes.',
    'numeric' => 'The :attribute must be at least :min.',
    'string' => 'The :attribute must be at least :min characters.',
  ],
  'multiple_of' => 'The :attribute must be a multiple of :value.',
  'not_in' => 'The selected :attribute is invalid.',
  'not_regex' => 'The :attribute format is invalid.',
  'numeric' => 'O :attribute precisa ser um número.',
  'password' => 'The password is incorrect.',
  'present' => 'The :attribute field must be present.',
  'prohibited' => 'The :attribute field is prohibited.',
  'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
  'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
  'prohibits' => 'The :attribute field prohibits :other from being present.',
  'regex' => 'The :attribute format is invalid.',
  'required' => 'Por favor preencha o campo ":attribute".',
  'required_array_keys' => 'The :attribute field must contain entries for: :values.',
  'required_if' => 'The :attribute field is required when :other is :value.',
  'required_unless' => 'The :attribute field is required unless :other is in :values.',
  'required_with' => 'The :attribute field is required when :values is present.',
  'required_with_all' => 'The :attribute field is required when :values are present.',
  'required_without' => 'The :attribute field is required when :values is not present.',
  'required_without_all' => 'The :attribute field is required when none of :values are present.',
  'same' => 'The :attribute and :other must match.',
  'size' => [
    'array' => 'O campo :attribute precisa conter :size itens.',
    'file' => 'O campo :attribute precisa ser de :size kilobytes.',
    'numeric' => 'O campo :attribute precisa ser :size.',
    'string' => 'O campo :attribute precisa ter :size characteres.',
  ],
  'starts_with' => 'The :attribute must start with one of the following: :values.',
  'string' => 'O campo :attribute precisa ser do tipo texto.',
  'timezone' => 'The :attribute must be a valid timezone.',
  'unique' => 'O valor do campo ":attribute" já está sendo usado.',
  'uploaded' => 'The :attribute failed to upload.',
  'url' => 'O campo :attribute precisa ser uma URL válida.',
  'uuid' => 'The :attribute must be a valid UUID.',

  'set_all_required' => 'Por favor preencha todos os campos obrigatórios.',

  /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

  'custom' => [
    'attribute-name' => [
      'rule-name' => 'custom-message',
    ],
  ],

  /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

  'attributes' => [
    'password' => 'senha',

    'country' => [
      'name' => 'Nome',
      'alfa2' => 'Alfa 2',
      'alfa3' => 'Alfa 3',
    ],

    'language' => [
      'name' => 'Nome',
      'code' => 'Código',
      'locale' => 'Localização',
      'image' => 'Imagem',
    ],

    'stock_status' => [
      'language_id' => 'Idioma',
      'name' => 'Nome',
    ],

    'product' => [
      'model' => 'Modelo',
      'condition' => 'Condição',
      'stock_status_id' => 'Situação do Estoque',
      'manufacturer_id' => 'Fabricante',
      'shipping' => 'Precisa de entrega?',
      'date_available' => 'Disponível em',
      'weight_id' => 'Unidade de Peso',
      'length_id' => 'Unidade de Medida',
      'subtract' => 'Reduzir Estoque?',
      'minimum' => 'Mínimo por Venda',
      'sort_order' => 'Ordem',
      'status' => 'Situação',
      'isbn13' => 'ISBN13',
      'descriptions' => 'Descrições',
      'stock' => 'Estoque',
      'seo' => "SEO",
    ],
    'product.descriptions.*.language_id' => 'ID do Idioma',
    'product.descriptions.*.name' => 'Nome do Produto',
    'product.descriptions.*.description' => 'Descrição',
    'product.seo.*.language_id' => 'ID do Idioma',
    'product.seo.*.meta_title' => 'Meta Título',
    'product.seo.*.meta_url' => 'URL Amigável',
    'product.seo.*.meta_description' => 'Meta Descrição',
    'product.seo.*.meta_tags' => 'Meta Tags',
    'product.stock.*.nf_id' => 'ID da Nota Fiscal',
    'product.stock.*.product_id' => 'ID do Produto',
    'product.stock.*.quantity' => 'Quantidade',
    'product.stock.*.quantity_sold' => 'Quantidade Vendida',
    'product.stock.*.has_stock' => 'Tem estoque?',
    'product.stock.*.price' => 'Preço',
  ],

];
