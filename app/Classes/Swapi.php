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

        if ($limit)  $people = $people->take($limit);

        return $people->values();
    }

    public static function getAllPlanets(int $limit = null, int $offset = null)
    {
        $data = Http::get(env('SWAPI_BASE_URL') . 'planets')->object();

        $planets = collect($data->results);

        if ($offset) $planets = $planets->slice($offset);

        if ($limit)  $planets = $planets->take($limit);

        return $planets->values();
    }

    public static function getAllVehicles(int $limit = null, int $offset = null)
    {
        $data = Http::get(env('SWAPI_BASE_URL') . 'vehicles')->object();

        $vehicles = collect($data->results);

        if ($offset) $vehicles = $vehicles->slice($offset);

        if ($limit)  $vehicles = $vehicles->take($limit);

        return $vehicles->values();
    }

    public static function getPeopleById(int $id)
    {
        $person = Http::get(env('SWAPI_BASE_URL') . "people/$id")->object();

        if (isset($person->detail) && $person->detail === "Not found") return false;

        return $person;
        
    }    

    public static function getPlanetById(int $id)
    {
        $planet = Http::get(env('SWAPI_BASE_URL') . "planets/$id")->object();

        if (isset($planet->detail) && $planet->detail === "Not found") return false;

        return $planet;
    }

    public static function getVehicleById(int $id)
    {
        $vehicle = Http::get(env('SWAPI_BASE_URL') . "vehicles/$id")->object();

        if (isset($vehicle->detail) && $vehicle->detail === "Not found") return false;

        return $vehicle;
    }
}