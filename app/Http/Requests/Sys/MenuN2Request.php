<?php

namespace App\Http\Requests\Sys;

use Illuminate\Foundation\Http\FormRequest;

class MenuN2Request extends FormRequest
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
            'menu_n1_id' => 'required',
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
            'menu_n1_id.required' => 'Menu N1 é obrigatório',
            'title.required' => 'Título é obrigatório',
            'icon.required' => 'Icone é obrigatório',   
            'to.required' => 'Rota do frontend é obrigatória',   
            'route_api.required' => 'Rota da API é obrigatória',   
            'status.required' => 'Status é obrigatório',       
        ];
    }
}
