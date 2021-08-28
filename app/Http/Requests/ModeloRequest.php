<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModeloRequest extends FormRequest
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
        $regras = [
            'marca_id' => ['exists:marcas,id'],
            'nome' => ['required','min:3', Rule::unique('modelos')->ignore($this->modelo)],
            'imagem' => ['required','file','image', 'mimes:png,jpg,jpeg'],
            'numero_portas' => ['required','integer','between:1,5'],
            'lugares' => ['required','integer','between:1,100'],
            'air_bag' => ['required','boolean'],
            'abs' => ['required','boolean'],
        ];

         if ($this->method() === 'PATCH') {
            $regrasDinamicas = array();
            //Percorre todas as regras
            foreach ($regras as $input => $regra) {
                //Coleta apenas as regras aplicáveis aos paramétros passados
                if (array_key_exists($input, $this->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            return $regrasDinamicas;
        }else{
            return $regras;
        }
    }
}
