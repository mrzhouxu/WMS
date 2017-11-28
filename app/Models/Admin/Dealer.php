<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Dealer extends Model
{

    static public function index(){

    }

    /*得到经销商列表*/
    static public function get_data($key='',$val=''){
        $result = DB::table('dealer')
            ->when($key && $val , function($query)use($key,$val){
                $query->where($key,$val);
            })
            ->where('status',0)
            ->get();
        return $result;
    }

    /*添加经销商*/
    static public function add_dealer_get_id($name,$phone,$address){
        $data = [
            'name'=>$name,
            'phone'=>$phone,
            'address'=>$address
        ];
        $id = DB::table('dealer')
            ->insertGetId($data);
        return $id;
    }

    /*更新经销商信息*/
    static public function update_dealer_info($id,$data){
        $result = DB::table('dealer')
            ->where('status',0)
            ->where('id',$id)
            ->update($data);
        return $result;
    }

    /*更新经销商产品信息*/
    static public function update_dealer_product($id,$data){
        $result = DB::table('dealer_commodity')
            ->where('id',$id)
            ->update($data);
        return $result;
    }

    /*添加经销商的产品*/
    static public function add_dealer_product($dealer_id,$name,$type,$in_price,$out_price,$unit,$img){
        $data = [
            'dealer_id'=>$dealer_id,
            'name'=>$name,
            'type'=>$type,
            'in_price'=>$in_price,
            'out_price'=>$out_price,
            'unit'=>$unit,
            'img'=>$img,
            'status'=>0
        ];
        $result = DB::table('dealer_commodity')
            ->insert($data);
        return $result;
    }

    /*得到经销商信息*/
    static public function get_info($id){
        $result = DB::table('dealer')
            ->where('status',0)
            ->where('id',$id)
            ->first();
        return $result;
    }

    /*得到经销商的产品*/
    static public function get_product($id){
        $result = DB::table('dealer_commodity')
            ->where('dealer_id',$id)
            ->where('status',0)
            ->get();
        return $result;
    }

    /*删除供销商*/
    static public function del($id){
        $result = DB::table('dealer')
            ->where('id',$id)
            ->update(['status'=>1]);
        return $result;
    }

}