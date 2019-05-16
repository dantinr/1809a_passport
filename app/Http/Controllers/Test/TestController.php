<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    //

    public function userAdd()
    {
        echo __METHOD__;

        echo '<pre>';print_r($_POST);echo '</pre>';
        $json_str = file_get_contents("php://input");
        echo 'json_str: '.$json_str;

    }

    public function testRedis()
    {
        $key = 'aaaa';
        Redis::set($key,123123);
        echo Redis::get($key);
    }

}
