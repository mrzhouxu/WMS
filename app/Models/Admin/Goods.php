<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Goods extends Model
{

    static public function index(){

    }

    /*查询分类数据*/
    static public function get_type_data($name){

        $result = DB::table('commodity_type')
            ->when($name , function($query)use($name){
                $query->where('name','like','%'.$name.'%');
            })
            ->where('status',0)
            ->get();
        return $result;
    }
    static public function _id_get_type_data($id){

        $result = DB::table('commodity_type')
            ->when($id , function($query)use($id){
                $query->where('id',$id);
            })
            ->where('status',0)
            ->first();
        return $result;
    }

    /*添加分类*/
    static public function add_type($name){
        $result = DB::table('commodity_type')
            ->insert([
                'name'=>$name
            ]);
        return $result;
    }

    /*编辑分类*/
    static public function edit_type($id,$data){
        $result = DB::table('commodity_type')
            ->where('id',$id)
            ->update($data);
        return $result;
    }

    /*删除分类*/
    static public function del_type($id){
        $result = DB::table('commodity_type')
            ->where('id',$id)
            ->update([
                'status'=>1
            ]);
        return $result;
    }

    /*得到所有供销商的商品
        $key, 字段
        $val, 值
        $selType 类型值
    */
    static public function get_dealer_data($key='',$val='',$selType=''){
        $result = DB::table('dealer_commodity')
            ->when($key&&$val,function($query)use($key,$val){
                $query->where($key,'like','%'.$val.'%');
            })
            ->when($selType,function($query)use($selType){
                $query->where('type',$selType);
            })
            ->where('status',0)
            ->get();
        return $result;
    }

    /*添加商品*/
    static public function add_goods($data){
        $result = DB::table('commodity')
            ->insert($data);
        return $result;
    }

    /*更新商品信息*/
    static public function update_goods($dealer_commodity_id='',$data,$id=''){
        $result = DB::table('commodity')
            ->when($dealer_commodity_id,function($query)use($dealer_commodity_id){
                $query->where('dealer_commodity_id',$dealer_commodity_id);
            })
            ->when($id,function($query)use($id){
                $query->where('id',$id);
            })
            ->where('status',0)
            ->update($data);
        return $result;
    }

    /*查看商品信息*/
    static public function get_goods($dealer_commodity_id=""){
        $result = DB::table('commodity')
            ->when($dealer_commodity_id,function($query)use($dealer_commodity_id){
                $query->where('dealer_commodity_id',$dealer_commodity_id);
            })
            ->where('status',0)
            ->first();
        return $result;
    }

    /*查看所有商品信息*/
    static public function get_goods_data($key='',$val='',$selType=''){
        $result = DB::table('commodity')
            ->when($key&&$val,function($query)use($key,$val){
                $query->where($key,'like','%'.$val.'%');
            })
            ->when($selType,function($query)use($selType){
                $query->where('type',$selType);
            })
            ->where('status',0)
            ->get();
        return $result;
    }

    /*生成订单*/
    static public function create_order($data){
        $result = DB::table('order')
            ->insertGetId($data);
        return $result;
    }
    /*更新订单*/
    static public function update_order($id,$data){
        $result = DB::table('order')
            ->where('id',$id)
            ->update($data);
        return $result;
    }
    /*添加订单商品*/
    static public function add_order_commodity($data){
        $result = DB::table('order_commodity')
            ->insert($data);
        return $result;
    }

}