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

    public function get_data(){
        $result = Employee::get_data()->toArray();
        return json_encode(['status'=>0,'msg'=>'success','result'=>$result]);
    }

}