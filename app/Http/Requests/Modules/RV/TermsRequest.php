<?php

namespace App\Http\Requests\Modules\RV;

use Illuminate\Foundation\Http\FormRequest;

class TermsRequest extends FormRequest
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
            'file' => 'required|array|max:10',
            'file.*' => 'mimes:docx|max:100',
            'status' => 'required|integer',
            'ref' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'É obrigatório enviar ao menos um arquivo.',
            'file.array' => 'O campo arquivo deve ser uma matriz de arquivos.',
            'file.max' => 'Devem ser enviados no máximo :max arquivos.',
            'file.*.mimes' => 'O arquivo deve ser tipo :values.',
            'file.*.max' => 'O arquivo deve ter no máximo :maxkb .',
          
            'status.required' => 'O campo status é obrigatório.',
            'status.integer' => 'O campo status deve ser um número inteiro.',
            'ref.required' => 'O campo referência é obrigatório.',
            'ref.date' => 'O campo referência deve ser uma data válida no formato yyyy-mm-dd.'
        ];
    }

    public function withValidator($validator)
    {
        // O método "after" é chamado após a validação padrão das regras
        $validator->after(function ($validator) {
            // Inicializa a variável que irá armazenar o tamanho total dos arquivos em bytes
            $totalSize = 0;
            $maxSize = 1024000;
            // Loop através dos arquivos enviados para obter o tamanho total em bytes
            foreach ($this->file('file') as $file) {
                $totalSize += $file->getSize();
            }
            // Verifica se o tamanho total dos arquivos é maior do que 100MB (102400 KB)
            if ($totalSize > $maxSize) {
                // Adiciona um erro personalizado na validação informando que o tamanho total dos arquivos não pode ser maior do que 100MB
                $validator->errors()->add('file_total_size', 'O tamanho total dos arquivos não pode ser maior que ' . round($maxSize / 1024 / 1024, 2)  . 'MB.');
            }
        });
    }
}
