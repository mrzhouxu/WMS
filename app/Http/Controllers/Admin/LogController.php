<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class LogController extends Controller
{
    public function index(Request $request){
        $result =  DB::table('logs')->get();
        return json_encode($result);
    }

}