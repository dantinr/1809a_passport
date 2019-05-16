<?php

namespace App\Http\Controllers\Api;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * API登录
     */
    public function login(Request $request)
    {
        $u = $request->input('u');
        $p = $request->input('p');
        $c = $request->input('c');


        //查库
        $u = UserModel::where(['email'=>$u])->first();

        if($u){
            //验证密码
            if (password_verify($p,$u->pass) ){     //密码正确
                //生成token
                $token = strtolower(Str::random(16));
                $key = 'str:app:plat:' .$c. ':login_token:uid:' .$u->uid;
                Redis::set($key,$token);
                Redis::expire($key,300);

                $response = [
                    'errno' => 0,
                    'msg'   => 'ok',
                    'data'  => [
                        'token' => $token,
                        'uid'   => $u->uid
                    ]
                ];
            }else{
                $response = [
                    'errno' => 40002,
                    'msg'   => 'password wrong!',
                ];
            }

        }else{      //用户不存则
            $response = [
                'errno' => 40001,
                'msg'   => 'User Not Exist'
            ];
        }


        die( json_encode($response) );
    }
}
