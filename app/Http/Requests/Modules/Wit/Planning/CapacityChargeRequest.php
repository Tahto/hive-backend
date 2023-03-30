<?php

namespace App\Http\Requests\Modules\Wit\Planning;

use Illuminate\Foundation\Http\FormRequest;

class CapacityChargeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => 'required|mimes:csv,txt|max:50000',
            'status' => 'required|integer',
            'ref' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => "Arquivo é obrigatório",
            'file.mimes' => "Arquivo deve ser um csv",
            'file.max' => "O Arquivo deve ter no máximo 50Mb",
            'status.required' => 'Status é obrigatório',
            'status.integer' => 'Status deve ser um número inteiro',
            'ref.required' => 'Mês de referência é obrigatório',
            'ref.date' => 'Mês de referência deve ser uma data ',
        ]   ;
    }
}
