<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Index;
use App\Models\Admin\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){

    }

    public function get_data(Request $request){
        $key = $request->key;
        $val = $request->val;
        $start_time = $request->start_time;
        $end_time = $request->end_time+86399;;
        $result = Order::get_data($key,$val,$start_time,$end_time)->toArray();
        foreach ($result as $item){
            $item->products = Order::get_order_commodity($item->id);
        }
        return json_encode(['status'=>0,'msg'=>'success','result'=>$result]);
    }

    public function del(Request $request){
        $id = $request->id;
        Order::del($id);
        return json_encode(['status'=>0,'msg'=>'success']);
    }

}