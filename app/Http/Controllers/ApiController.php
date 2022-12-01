<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Traits\BasicApiFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Classes\Swapi;
use App\Http\Requests\FiltrableResourceRequest;
use App\Http\Requests\SpecificResourceRequest;

class ApiController extends Controller
{
    use BasicApiFunctions;

    public function __construct()
    {
        /**
         * Todos los endpoint de la API estan protegidos por autenticación JWT,
         * excepto para los mètodos de Login, Register y el endpoint de Test
         */
        $this->middleware('jwt_token', ['except' => ['login', 'register', 'test']]);
    }

    /**
     * Prueba simple de funcionamiento
     */
    public function test()
    {
        return $this->success("La API funcionando está, mi joven padawan");
    }

    /**
     * Inicio de sesión basado en correo y contraseña del usuario
     */
    public function login(LoginRequest $request)
    {
        $token = Auth::attempt($request->validated());

        if (!$token)
        {
            return $this->error('Usuario inexistente, revise sus credenciales', 
                "Tus ojos pueden engañarte, no confíes en ellos. Atte: Obi-Wan"
            );
        } 

        $user = Auth::user();

        return $this->success([
            'message' => "Toma este token, $user->name, y úsalo con sabiduría.",
            'user'    => $user,
            'authorization' => [
                'token' => $token,
                'type'  => 'bearer'
            ]
        ]);
    }

    /**
     * Registro de usuario
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return $this->success([
            'message' => "¡Bienvenido a bordo, $user->name!. Aquí tienes tu token",
            'user'    => $user,
            'authorization' => [
                'token' => $token,
                'type'  => 'bearer'
            ]
        ]);
    }

    // **********  RECURSOS DE LA API  **********

    /**
     * Retorna todos los recursos de personas
     */
    public function getAllPeople(FiltrableResourceRequest $request)
    {
        $data = Swapi::getAllPeople($request->limit, $request->offset);
        return $this->success(compact('data'));
    }

    /**
     * Retorna todos los recursos de planetas
     */
    public function getAllPlanets(FiltrableResourceRequest $request)
    {
        $data = Swapi::getAllPlanets($request->limit, $request->offset);
        return $this->success(compact('data'));
    }

    /**
     * Retorna todos los recursos de vehiculos
     */
    public function getAllVehicles(FiltrableResourceRequest $request)
    {
        $data = Swapi::getAllVehicles($request->limit, $request->offset);
        return $this->success(compact('data'));
    }

    /**
     * Retorna un recurso de person por su ID
     */
    public function getPeopleById(SpecificResourceRequest $request)
    {
        $person = Swapi::getPeopleById($request->id);

        if (!$person) return $this->error('Personaje no encontrado', 
            'Es posible que no exista un recurso con el ID envíado', 404
        );

        return $this->success(['data' => $person]);
    }

    /**
     * Retorna un recurso de planeta por su ID
     */
    public function getPlanetById(SpecificResourceRequest $request)
    {
        $planet = Swapi::getPlanetById($request->id);

        if (!$planet) return $this->error('Planeta no encontrado', 
            'Es posible que no exista un recurso con el ID envíado', 404
        );

        return $this->success(['data' => $planet]);
    }

    /**
     * Retorna un recurso de vehiculo por su ID
     */
    public function getVehicleById(SpecificResourceRequest $request)
    {
        $vehicle = Swapi::getVehicleById($request->id);

        if (!$vehicle) return $this->error('Vehiculo no encontrado', 
            'Es posible que no exista un recurso con el ID envíado', 404
        );

        return $this->success(['data' => $vehicle]);
    }

}
