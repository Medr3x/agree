<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Traits\UserLoginTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
/**
 * @OA\Post(
 *      path="/api/auth/login",
 *      tags={"Auth"},
 *      summary="Login",
 *      description="Returns barear token",
 *      @OA\Parameter(
 *          name="Content-Type",
 *          description="application/json",
 *          required=true,
 *          in="header",
 *      ),
 *      @OA\RequestBody(
 *          @OA\JsonContent(
 *              @OA\Property(property="email", type="email"),
 *              @OA\Property(property="password", type="string")
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Success",
 *       )
 *  )
 * @OA\Post(
 *      path="/api/auth/logout",
 *      tags={"Auth"},
 *      summary="Logout",
 *      description="Close the session",
 *      @OA\Parameter(
 *          name="Authorization",
 *          description="Token obtenido al iniciar sesion",
 *          required=true,
 *          in="header",
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Success",
 *       )
 *  )
*/
class LoginController extends Controller
{   
    use UserLoginTrait;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        attemptLogin as baseAttemptLogin;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|mixed
     * @throws \Exception
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    protected function authenticated(Request $request, User $user)
    {
        return $this->doLogin($user);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return apiResponse([], 'Su sesion se ha cerrado.');
    }
}