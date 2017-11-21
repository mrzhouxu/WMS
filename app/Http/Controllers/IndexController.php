<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use DB;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        //依据角色判断跳转到哪里
        $user = get_session_user();
        if ($user) {
//        if (false) {
            return view('admin');
        }
        return view("login");

    }

    //测试专用
    public function test () {
    	echo "测试";
    }

    public function show_img(Request $request) {
        $path = storage_path() . '/app/public/img/' . $request->name;
        if(file_exists($path)) {
            return response()->file($path);
        }
    }
}