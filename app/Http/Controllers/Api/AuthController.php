<?php

namespace App\Http\Controllers\Api;

use DB;
use Log;
use Hash;
use Auth;
use Validator;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Api\MasterController;
use Illuminate\Support\Facades\Password;
use App\Notifications\ForgotPasswordNotification;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class AuthController extends MasterController
{
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
    	$input = $request->all();

    	$validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, [], ['message' => $validator->errors()], 422);            
        }

        $user = User::where('email', $input['email'])->first();

        if (!$user) {
            return $this->sendResponse(false, [], ['message' => 'Email hoặc Mật khẩu không đúng!'], 422);
        }

        if (Hash::check($input['password'], $user->password)) {

        	// create token
            $token_result = $user->createToken('Personal Access Token');
            $token = $token_result->token;

            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(4);

            $token->save();  

            $data = [
                'access_token' => $token_result->accessToken,
                'token_type' => 'Bearer',
                'user' => $user,
                'expires_at' => Carbon::parse($token_result->token->expires_at)->toDateTimeString()
            ];

            return $this->sendResponse(true, $data, [], 200);
        } else {
            return $this->sendResponse(false, [], ['message' =>'Email hoặc Mật khẩu không đúng!'], 422);
        }

    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return $this->sendResponse(true, $data, ['message' => 'Log out thành công'], 200);
    }


}
