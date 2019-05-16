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


    /**
     * API 用户注册
     * @param Request $request
     */
    public function reg(Request $request)
    {
        $u = $request->input('u_name');
        $e = $request->input('u_email');
        $p1 = $request->input('pass1');
        $p2 = $request->input('pass2');

        //确认密码
        if($p1 !== $p2){
            $response = [
                'errno' => 50006,
                'msg'   => 'confirm password!'
            ];

            die( json_encode($response) );
        }

        // 生成密码
        $pass = password_hash($p1,PASSWORD_DEFAULT);

        //验证email是否已存在
        $user = UserModel::where(['email'=>$e])->first();
        if($user){      //用户已存在
            $response = [
                'errno' => 50007,
                'msg'   => 'email exists!'
            ];
            die( json_encode($response));
        }else{
            $data = [
                'name'  => $u,
                'email' => $e,
                'pass'  => $pass,
                'add_time'  => time()
            ];

            $uid = UserModel::insertGetId($data);

            if(!$uid){      //数据库写入失败
                $response = [
                    'errno' => 50008,
                    'msg'   => 'Db Insert Err'
                ];
                die( json_encode($response));
            }
        }

        $response = [
            'errno' => 0,
            'msg'   => 'Reg success!'
        ];

        die( json_encode($response));

    }

}
