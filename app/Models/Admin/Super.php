<?php

namespace App\Models\Admin;

use DB;
use Log;

class Super
{

    /*登陆判断*/
    public static function get_account($loginName)
    {
        $res = DB::table('employee')
            ->where(['user'=>$loginName])
            ->first();
        return $res;
    }

    static function is_password_right($pwd)
    {
        $user = DB::table('employee')->where('id', get_session_user_id())->first();
        return $user->password == encrypt_password($pwd);
    }
    static function change_password($new_pwd)
    {
        $password = encrypt_password($new_pwd);
        $res = DB::table('employee')
            ->where('id', get_session_user_id())
            ->update(['password' => $password, 'update_time' => time()]);
        return $res;
    }

    /*登录日志
    */
    static function log($user_id,$content){
        DB::table('logs')
            ->insert([
                'user_id'=>$user_id,
                'content'=>$content,
                'create_time'=>time()
            ]);
    }

}

