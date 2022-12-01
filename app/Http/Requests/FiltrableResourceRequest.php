<?php

namespace App\Http\Requests;

use App\Traits\BasicApiFunctions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class FiltrableResourceRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // Se validan los filtros opcionales para los recursos de la API
        $rules = [
            'limit'  => 'nullable|numeric|max:10',
            'offset' => 'nullable|numeric|max:10'
        ];

        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->error('Error al validar los filtros', $validator->errors(), 400)
        );
    }
}
