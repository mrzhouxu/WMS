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

    /*得到店员信息*/
    static public function get_info($id){
        $result = DB::table('employee')
            ->where('id',$id)
            ->where('status',0)
            ->select('id','name','sex','address','phone','img','card','user')
            ->first();
        return $result;
    }

    /*编辑店员信息
     * */
    static public function edit($id,$data){
        $result = DB::table('employee')
            ->where('id',$id)
            ->update($data);
        return $result;
    }

    /*删除店员信息*/
    static public function del($id){
        $result = DB::table('employee')
            ->where('id',$id)
            ->update(['status'=>1]);
        return $result;
    }

    /*重置店员密码*/
    static public function reset($id){
        $result = DB::table('employee')
            ->where('id',$id)
            ->update(['password'=>md5(md5('666666'))]);
        return $result;
    }

    /*添加店员*/
    static public function add($data){
        $result = DB::table('employee')
            ->insert($data);
        return $result;
    }

    /*判断登陆账号是否存在*/
    static public function judge_user($user){
        $result = DB::table('employee')
            ->where('status',0)
            ->where('user',$user)
            ->first();
        return $result;
    }
}