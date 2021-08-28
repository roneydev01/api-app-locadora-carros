<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MarcaRequest extends FormRequest
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
            'nome' => ['required','min:3', Rule::unique('marcas')->ignore($this->marca)],
            'imagem' => ['required','image', 'mimes:png,jpg'],
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
