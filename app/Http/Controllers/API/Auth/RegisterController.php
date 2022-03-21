<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\UserLoginTrait;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
/**
 * @OA\Post(
 *      path="/api/auth/register",
 *      tags={"Auth"},
 *      summary="Register",
 *      description="Registro de usuario, se puede elegir 3 roles:
 *      admin, player y card_makers",
 *      @OA\Parameter(
 *          name="Content-Type",
 *          description="application/json",
 *          required=true,
 *          in="header",
 *      ),
 *      @OA\RequestBody(
 *          @OA\JsonContent(
 *              @OA\Property(property="email", type="email"),
 *              @OA\Property(property="password", type="string"),
 *              @OA\Property(property="name", type="string"),
 *              @OA\Property(property="rol", type="string"),
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Success",
 *       )
 *  )
 */
class RegisterController extends Controller
{
    use RegistersUsers, UserLoginTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function register(Request $request)
    {
        $user = $this->createUserObject($request);
        return $this->doLogin($user, 'Se ha registrado satisfactoriamente!');
    }

    protected function createUserObject($request)
    {
        $data = $request->all();
        $this->validator($data)->validate();
        $rol = $data['rol'];
        $data = $request->except('rol');
        $user = $this->create($data, $rol);
        return $user;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'rol' => 'required|exists:roles,name'
        ];
        
        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    protected function create(array $data, $rol)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        $user->assignRole($rol);
        return $user;
    }
}