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
}