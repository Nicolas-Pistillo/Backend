<?php 

namespace App\Classes;

use App\Traits\BasicApiFunctions;
use Illuminate\Support\Facades\Http;

/**
 * Clase para manejo de solicitudes HTTP hacia la API de StarWars.
 * "Que las buenas prácticas te acompañen"
 */
class Swapi
{
    use BasicApiFunctions;

    public static function getAllPeople(int $limit = null, int $offset = null)
    {
        $data = Http::get(env('SWAPI_BASE_URL') . 'people')->object();

        $people = collect($data->results);

        if ($offset) $people = $people->slice($offset);

        if ($limit) $people = $people->take($limit);

        return $people->values();
    }
}