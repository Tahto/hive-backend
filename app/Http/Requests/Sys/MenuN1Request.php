<?php

namespace App\Http\Requests\Sys;

use Illuminate\Foundation\Http\FormRequest;

class MenuN1Request extends FormRequest
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
            'module_id' => 'required',
            'title' => 'required',
            'icon' => 'required',
            'to' => 'required',
            'route_api' => 'required', 
            'status' => 'required|boolean',           
        ];        
    }

  
    public function messages()
    {
        return [
            'module_id.required' => 'Módulo é obrigatório',
            'title.required' => 'Título é obrigatório',
            'icon.required' => 'Icone é obrigatório',   
            'to.required' => 'Rota do frontend é obrigatória',   
            'route_api.required' => 'Rota da API é obrigatória',   
            'status.required' => 'Status é obrigatório',       
        ];
    }
}
