<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class LogController extends Controller
{
    public function index(Request $request){
        $start = $request->start_time;
        $end = $request->end_time+86399;

        $result =  DB::table('logs')
            ->when($start && $end , function ($query) use ($start , $end) {
                $query->whereBetween('create_time',[$start,$end]);
            })
            ->orderBy('create_time','desc')
            ->get();
        return json_encode($result);
    }

}