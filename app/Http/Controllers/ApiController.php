<?php

namespace App\Http\Controllers;

use App\Traits\ApiFunctions;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiFunctions;

    public function test()
    {
        return $this->success("Prueba finalizada exitosamente! :D");
    }

    
}
