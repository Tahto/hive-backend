<?php

namespace App\Http\Requests\Sys;

use Illuminate\Foundation\Http\FormRequest;

class AppRequest extends FormRequest
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
            'title' => 'required',
            'route_api' => 'required',
            'menu_n2_id' => 'required',
            'status' => 'required|boolean',           
        ];        
    }

  
    public function messages()
    {
        return [
            'title.required' => 'Título é obrigatório',
            'route_api.required' => 'Rota da API é obrigatória',   
            'menu_n2_id.required' => 'Menu N2 é obrigatório',   
            'status.required' => 'Status é obrigatório',       
        ];
    }
}
