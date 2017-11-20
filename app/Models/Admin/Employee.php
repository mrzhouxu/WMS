<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Employee extends Model
{

    static public function index(){

    }

    /*得到员工信息
     * */
    static public function get_data($key,$val){
        $result = DB::table('employee')
            ->when($key && $val , function($query)use($key,$val){
                $query->where($key,$val);
            })
            ->where('status',0)
            ->select('id','name','sex','address','phone','img','card','user')
            ->get();
        return $result;
    }
}