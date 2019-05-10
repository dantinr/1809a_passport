<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

}
