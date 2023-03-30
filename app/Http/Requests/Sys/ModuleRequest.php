<?php

namespace App\Http\Requests\Sys;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModuleRequest extends FormRequest
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
            'title' => 'required|unique:sys_modules,title,' . $this->id,
            'icon' => 'required',
            'to' => 'required',
            'status' => 'required|boolean',
            'menuN1' => 'array',
            'menuN1.*.title' => 'required',
            'menuN1.*.to' => 'required',
            'menuN1.*.icon' => 'required',
        ];        
    }

  
    public function messages()
    {
        return [
            'title.required' => 'Título é obrigatório',
            'title.unique' => 'Título não pode ser repetido',
            'icon.required' => 'Icone é obrigatório',   
            'to.required' => 'Diretório é obrigatório',   
            'status.required' => 'Status é obrigatório',   
            'menuN1.array' => 'Menu N1 deve ser um array',          
            'menuN1.*.title.required' => 'Título do menu é obrigatório',          
            'menuN1.*.to.required' => 'Rota do menu é obrigatório',          
            'menuN1.*.icon.required' => 'Icone do menu é obrigatório',          
        ];
    }
}
