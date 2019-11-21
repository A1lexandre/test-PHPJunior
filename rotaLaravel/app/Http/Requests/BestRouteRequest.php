<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BestRouteRequest extends FormRequest
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
            'ponto_inicial' => 'required|size:1',
            'ponto_final' => 'required|size:1',
            'autonomia' => 'required|numeric',
            'l_combustivel' => 'required|numeric'
        ];
    }

    public function messages() {
        return [
            'ponto_inicial.required' => 'Ponto inicial é obrigatório',
            'ponto_final.required' => 'Ponto final é obrigatório',
            'ponto_inicial.size' => 'Ponto inicial deve ser de um caractere',
            'ponto_final.size' => 'Ponto final deve ser de um caractere',
            'autonomia.required' => 'Autonomia é obrigatório',
            'autonomia.numeric' => 'Autonomia dever ser do tipo numérico',
            'l_combustivel.required' => 'O litro do combustível é obrigatório',
            'l_combustivel.numeric' => 'O litro do combustível deve ser do tipo numérico'
        ];
    }
}
