<?php

namespace App\Http\Requests\Modules\Reports\PowerBi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PowerbiRequest extends FormRequest
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
            'title' => 'required:unique',
            'url' => 'required',
            'status' => 'required|boolean',
            'owners' => 'required|array',
            // 'owners.*.owner_id' => 'required|unique:reports_power_bi_owners.*.owner_id'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Título é obrigatório',
            'url.required' => 'URL é obrigatória',
            'status.required' => 'Status é obrigatório',
            'status.boolean' => 'Status de ser boolean',           
            'owners.required' => 'Responsável é obrigatório',           
            'owners.array' => 'Responsável deve ser uma array',  
            'owners.*.owner_id.required' => 'Responsável é requerido',                 
        ];
    }
}
