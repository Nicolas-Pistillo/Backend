<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Traits\BasicApiFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    use BasicApiFunctions;

    public function __construct()
    {
        /**
         * Todos los endpoint de la API estan protegidos por autenticación JWT,
         * excepto para los mètodos de Login, Register y el endpoint de test
         */
        $this->middleware('auth:api', ['except' => ['login', 'register', 'test']]);
    }

    /**
     * Prueba simple de funcionamiento
     */
    public function test(Request $request)
    {
        return $this->success("La API funcionando está, mi joven {$request->ip()}");
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

        return $this->success([
            'message' => "Toma este token, y úsalo con sabiduría.",
            'user'    => Auth::user(),
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

}
