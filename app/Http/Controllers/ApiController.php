<?php

namespace App\Http\Controllers;

use App\Traits\ApiFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    use ApiFunctions;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'test']]);
    }

    /**
     * Prueba simple de funcionamiento
     */
    public function test(Request $request)
    {
        return $this->success("La API funcionando está, mi joven {$request->ip()}");
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'     => 'required|string|email',
            'password'  => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);

        if (!$token)
        {
            return $this->error('Credenciales incorrectas', 
                "Tus ojos pueden engañarte, no confíes en ellos. | Atte: Obi-Wan."
            );
        } 

        return $this->success([
            'message' => "Toma este token, y úsalo con sabiduría.",
            'user'    => Auth::user(),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);
    }

}
