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
    static public function get_data(){
        $result = DB::table('employee')
            ->where('status',0)
            ->select('name','sex','address','phone','img','card','user')
            ->get();
        return $result;
    }
}