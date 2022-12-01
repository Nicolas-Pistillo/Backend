<?php 

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait BasicApiFunctions
{
    /**
     * Retorna una respuesta de API axitosa
     * @param mixed $data La información a retornar
     */
    public function success($data = [])
    {
        $response = [
            'success'   => true,
            'time'      => time(),
            'response'  => $data,
        ];

        if (request()->has('tokenExpiration'))
        {
            $response['tokenExpiration'] = request('tokenExpiration');
        }

        return response()->json($response);
    }

    /**
     * Retorna una respuesta de error en la API
     * @param string $reason El motivo del error
     * @param string $data Un mensaje descriptivo o ayuda para resolver el error
     * @param int $codeStatus El código de estado que se enviara al cliente 
     */
    public function error(string $reason, $data, int $codeStatus = 401)
    {
        $response = [
            'success'       => false,
            'time'          => time(),
            'reason'        => $reason,
            'description'   => $data
        ];

        if (request()->has('tokenExpiration'))
        {
            $response['tokenExpiration'] = request('tokenExpiration');
        }

        return response()->json($response, $codeStatus);
    }
}