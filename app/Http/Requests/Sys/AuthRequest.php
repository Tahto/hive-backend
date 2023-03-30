<?php

namespace App\Http\Requests\Sys;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
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
            'id' => 'required',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return  [
            'id.required' => 'Usuário é obrigatório',
            'password.required' => 'Senha é obrigatória',
        ];
    }
}
