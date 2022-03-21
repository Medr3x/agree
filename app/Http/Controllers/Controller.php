<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="RESTful API - Yu-Gi-Oh!", version="1.0")
 * @OA\Server(url="http://agree.test:8080")
 * @OA\Tag(name="Auth",description="Estos endpoints manejan la autenticacion de los usuarios, su registro y cierre de sesion.")
 * @OA\Tag(name="Cards",description="Estos endpoints manejan el ABM de las cartas.")
 * @OA\Tag(name="Categories",description="Estos endpoints manejan el ABM de las categorias/tipos de las cartas.")
*/

//  * @OA\Get(
//  *     path="/",
//  *     description="Home page",
//  *     @OA\Response(response="default", description="Welcome page")
//  * )
// */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
