<?php

namespace App\Http\Requests\Modules\Reports\Boletim;

use Illuminate\Foundation\Http\FormRequest;

class HourHourIntraDayRequest extends FormRequest
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
            'dt_data' => 'required|date',
            'sectors_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'dt_data.required' => "Campo 'data' é obrigatório",
            'dt_data.date' => "Campo 'data' precisa ser uma data válida",
            'sectors_id.required' => "Campo 'setor' é obrigatório",
            'sectors_id.integer' => "Campo 'setor' precisa ser um inteiro",
                         
        ];
    }
}
