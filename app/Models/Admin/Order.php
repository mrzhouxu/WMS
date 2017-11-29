<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model
{

    static public function index(){

    }

    /*获得订单列表*/
    static public function get_data($key='',$val='',$start_time='',$end_time=''){
        $result = DB::table('order')
            ->where('is_delete',0)
            ->when( $key && $val , function($query) use($key,$val){
                $query->where($key,'like','%'.$val.'%');
            })
            ->when( $start_time && $end_time ,function($query) use($start_time,$end_time){
                $query->whereBetween('create_time',[$start_time,$end_time]);
            })
            ->get();
        return $result;
    }

    /*删除订单*/
    static public function del($id){
        $result = DB::table('order')
            ->where('id',$id)
            ->update(['is_delete'=>1]);
        return $result;
    }

    /*查找该订单商品*/
    static public function get_order_commodity($order_id){
        $result = DB::table('order_commodity')
            ->select('order_commodity.*')
            ->addSelect('dealer_commodity.name')
            ->LeftJoin('dealer_commodity','order_commodity.commodity_id','=','dealer_commodity.id')
            ->where('order_id',$order_id)
            ->get();
        return $result;
    }
}