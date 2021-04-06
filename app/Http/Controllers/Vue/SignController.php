<?php


namespace App\Http\Controllers\Vue;


use App\Http\Controllers\Controller;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class SignController extends Controller
{
    public function sign(Request $request){
        $data['tel'] = Input::post('tel');
        $data['pwd'] = Input::post('pwd');
        $data['pwd_confirmation'] = Input::post('pwd_confirmation');

        $rule = [
            'tel' => 'regex:/^1{1}[345789]{1}[0-9]{9}$/|required',
            'pwd' => 'regex:/^[a-zA-Z0-9]*[a-zA-Z]+[0-9]+[a-zA-Z0-9]*$/|required|max:20|min:6|confirmed',
            'pwd_confirmation' => 'required',
        ];

        $message = [
            'tel.regex' => '手机号有误',
            'tel.required' => '手机号必填',
            'pwd.required' => '密码必填',
            'pwd.min' => '密码为8-20位,必须是字母和数字的组合',
            'pwd.max' => '密码为8-20位,必须是字母和数字的组合',
            'pwd.regex' => '密码为8-20位,必须是字母和数字的组合',
            'pwd.confirmed' => '两次密码输入不同',
            'pwd_confirmation.required' => '确认密码必填',
        ];

        if ($this->validate($request, $rule, $message)) {
            $user = new User();
            $res = $user->where('tel',$data['tel'])->first();
            if ($res){
                $bool = ['code' => '1','msg' => '手机号已存在'];
                return json_encode($bool);
            }
            unset($data['pwd_confirmation']);
            $data['pwd'] = Hash::make($data['pwd']);
            $res = $user->insert($data);
            if ($res){
                $bool = ['code' => '0','message' => '注册成功,正在跳转登录页面'];
                return json_encode($bool);
            }else{
                $bool = ['code' => '1','msg' => '注册失败'];
                return json_encode($bool);
            }
        }
    }
}