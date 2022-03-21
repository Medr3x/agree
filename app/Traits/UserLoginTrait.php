<?php

namespace App\Traits;

use Carbon\Carbon;

trait UserLoginTrait
{
    /**
     * @param $user
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    protected function doLogin($user, $message = '')
    {
        $activeToken = $user->tokens()->where('revoked', false)->first();

        if ($activeToken) {
           $activeToken->revoke();
        }

        $tokenResult = $user->createToken(env('APP_NAME').'-API');

        $token = $tokenResult->token;

        $token->save();        

        $userDetails = $user;

        $userDetails['authorization'] = 'Bearer ' . $tokenResult->accessToken;

        $userDetails['expires_at'] = Carbon::parse(
            $tokenResult->token->expires_at
        )->toDateTimeString();

        return apiResponse($userDetails, $message);
    }
}