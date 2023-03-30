<?php

namespace App\Http\Requests\Sys;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoutePermissionRequest extends FormRequest
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
            'route_name' => 'required',
            'user_id' => 'required',
            'sector_n1_id' => 'required',
            'sector_n2_id' => 'required',
            'manager_n1_id' => 'required',
            'manager_n2_id' => 'required',
            'manager_n3_id' => 'required',
            'manager_n4_id' => 'required',
            'manager_n5_id' => 'required',
            'manager_n6_id' => 'required',
            'hierarchical_level' => 'required',
            'type' => 'required',
          
            'allowed' =>[
                'required', 
                Rule::unique('sys_route_permissions')
                    ->where(function ($query)  {
                        return $query                 
                        ->where('route_name', $this->input('route_name'))
                        ->where('user_id',$this->input('user_id'))
                        ->where('sector_n1_id',$this->input('sector_n1_id'))
                        ->where('sector_n2_id',$this->input('sector_n2_id'))
                        ->where('manager_n1_id',$this->input('manager_n1_id'))
                        ->where('manager_n2_id',$this->input('manager_n2_id'))
                        ->where('manager_n3_id',$this->input('manager_n3_id'))
                        ->where('manager_n4_id',$this->input('manager_n4_id'))
                        ->where('manager_n5_id',$this->input('manager_n5_id'))
                        ->where('manager_n6_id',$this->input('manager_n6_id'))
                        ->where('hierarchical_level',$this->input('hierarchical_level'))
                        ->where('type',$this->input('type'))
                        ->where('allowed',$this->input('allowed'));
                     })->ignore($this->id)
                       
               ]
        ];
    }

  
    public function messages()
    {
        return [
            'route_name.required' => 'Campo route_name requerido',
            'user_id.required' => 'Campo user_id requerido',
            'sector_n1_id.required' => 'Campo sector_n1_id requerido',
            'sector_n2_id.required' => 'Campo sector_n2_id requerido',
            'manager_n1_id.required' => 'Campo manager_n1_id requerido',
            'manager_n2_id.required' => 'Campo manager_n2_id requerido',
            'manager_n3_id.required' => 'Campo manager_n3_id requerido',
            'manager_n4_id.required' => 'Campo manager_n4_id requerido',
            'manager_n5_id.required' => 'Campo manager_n5_id requerido',
            'manager_n6_id.required' => 'Campo manager_n6_id requerido',
            'hierarchical_level.required' => 'Campo hierarchical_level requerido',
            'type.required' => 'Campo type requerido',
            'allowed.unique' => 'Registro em duplicidade',
        ];
    }
}
