<?php

return [
    'attributes' => [
        'password' => 'senha',
        'password_confirmation' => 'confirmação de senha',
        'old_password' => 'senha atual',
        'old_password_confirmation' => 'confirmação de senha atual',
        'email' => 'e-mail',
        'name' => 'nome',
        'cpf' => 'CPF',
        'cnpj' => 'CNPJ',
        'phone' => 'telefone',
        'cellphone' => 'celular',
        'address' => 'endereço',
        'number' => 'número',
        'complement' => 'complemento',
        'neighborhood' => 'bairro',
        'city' => 'cidade',
        'state' => 'estado',
        'zipcode' => 'CEP',
        'date' => 'data',
        'time' => 'hora',
        'description' => 'descrição',
        'image' => 'imagem',
        'file' => 'arquivo',
        'value' => 'valor',
        'quantity' => 'quantidade',
        'discount' => 'desconto',
        'total' => 'total',
        'status' => 'status',
        'type' => 'tipo',
        'category' => 'categoria',
    ],

    'required' => 'O campo :attribute é obrigatório.',
    'unique' => 'O campo :attribute já está em uso.',
    'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'confirmed' => 'O campo :attribute não confere.',
    'min' => [
        'string' => 'O campo :attribute deve ter no mínimo :min caracteres.',
    ],
    'max' => [
        'string' => 'O campo :attribute deve ter no máximo :max caracteres.',
    ],
    'numeric' => 'O campo :attribute deve ser um número.',
    'date' => 'O campo :attribute deve ser uma data válida.',
    'after' => 'O campo :attribute deve ser uma data posterior a :date.',
    'before' => 'O campo :attribute deve ser uma data anterior a :date.',
    'mimes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'image' => 'O campo :attribute deve ser uma imagem.',
    'size' => [
        'numeric' => 'O campo :attribute deve ser :size.',
        'file' => 'O campo :attribute deve ter :size kilobytes.',
        'string' => 'O campo :attribute deve ter :size caracteres.',
        'array' => 'O campo :attribute deve ter :size itens.',
    ],
    'between' => [
        'numeric' => 'O campo :attribute deve estar entre :min e :max.',
        'file' => 'O campo :attribute deve ter entre :min e :max kilobytes.',
        'string' => 'O campo :attribute deve ter entre :min e :max caracteres.',
        'array' => 'O campo :attribute deve ter entre :min e :max itens.',
    ],
    'digits' => 'O campo :attribute deve ter :digits dígitos.',
    'digits_between' => 'O campo :attribute deve ter entre :min e :max dígitos.',
    'regex' => 'O campo :attribute não é válido.',
    'exists' => 'O campo :attribute não existe.',
    'distinct' => 'O campo :attribute tem um valor duplicado.',
    'timezone' => 'O campo :attribute deve ser uma zona válida.',
    'alpha' => 'O campo :attribute deve conter apenas letras.',
    'alpha_dash' => 'O campo :attribute deve conter apenas letras, números e traços.',
    'alpha_num' => 'O campo :attribute deve conter apenas letras e números.',
    'in' => 'O campo :attribute não é válido.',
    'not_in' => 'O campo :attribute não é válido.',
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
    'url' => 'O campo :attribute não é válido.',
    'file' => 'O campo :attribute deve ser um arquivo.',
    'filled' => 'O campo :attribute é obrigatório.',
    'required_if' => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_unless' => 'O campo :attribute é obrigatório a menos que :other esteja em :values.',
    'required_with' => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_with_all' => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_without' => 'O campo :attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos :values está presente.',
    'same' => 'O campo :attribute e :other devem ser iguais.',
];