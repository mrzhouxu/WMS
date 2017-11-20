<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Employee;
use App\Models\Admin\Index;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){

    }

    public function get_data(Request $request){
        $key = $request->key;
        $val = $request->val;
        if($key == 'sex'){
            if($val == '男'){
                $val = 1;
            }else if($val == '女'){
                $val = 2;
            }else if($val == '未知'){
                $val = 0;
            }
        }
        $result = Employee::get_data($key,$val)->toArray();
        return json_encode(['status'=>0,'msg'=>'success','result'=>$result]);
    }

}