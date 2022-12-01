<?php

namespace App\Http\Requests;

use App\Traits\BasicApiFunctions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * Validación de un recurso especifico basado en su ID 
 */
class SpecificResourceRequest extends FormRequest
{
    use BasicApiFunctions;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    // El ID llega como parámetro de ruta a la validación
    protected function prepareForValidation() 
    {
        $this->merge(['id' => $this->route('id')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required|numeric|integer|min:1'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->error(
                'ID inválido', 
                'Si recurso tu quieres, ID numérico y entero enviar debes', 
                400
            )
        );
    }
}
