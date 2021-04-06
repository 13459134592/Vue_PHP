<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function login() {
        $tel = Input::post('tel');
        $pwd = Input::post('pwd');
        $jwt = JWTAuth::attempt(['tel' => $tel, 'password' => $pwd]);
        if ($jwt) {
            $data['code'] = '0';
            $data['data']['token'] = $jwt;
            $data['data']['tel'] = $tel;
            $data['msg'] = '登录成功!';
            return response()->json($data);
        } else {
            $data['code'] = '1';
            $data['data']= '';
            $data['msg'] = '登录失败，请检查账号密码';
            return response()->json($data);
        }
    }
}