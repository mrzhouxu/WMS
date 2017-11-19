<?php

namespace App\Models\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Excel;

/**
 * 用户管理
 * Class User
 * @package App\Models
 */
class User extends Model
{
    /*判断旧密码是否正确*/
    static public function is_password_right($old_pwd){
        $result = DB::table('employee')
            ->where('id',session('user')->id)
            ->where('password',md5(md5($old_pwd)))
            ->first();
        return $result;
    }

    /*修改密码*/
    static public function change_password($new_pwd){
        $result = DB::table('employee')
            ->where('id',session('user')->id)
            ->update(['password'=>md5(md5($new_pwd))]);
        return $result;
    }
}
