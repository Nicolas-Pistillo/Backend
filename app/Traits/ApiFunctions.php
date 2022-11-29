<?php 

namespace App\Traits;

trait ApiFunctions
{
    /**
     * Retorna una respuesta de API axitosa
     * @param mixed $data La información a retornar
     */
    public function success($data = [])
    {
        return response()->json([
            'success'   => true,
            'time'      => time(),
            'data'      => $data,
        ]);
    }

    /**
     * Retorna una respuesta de error en la API
     * @param string $reason El motivo del error
     * @param string $message Un mensaje descriptivo o ayuda para resolver el error
     */
    public function error(string $reason, string $message, int $codeStatus = 401)
    {
        return response()->json([
            'success'   => false,
            'time'      => time(),
            'reason'    => $reason,
            'message'   => $message
        ], $codeStatus);
    }
}