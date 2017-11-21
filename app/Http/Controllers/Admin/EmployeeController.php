<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Employee;
use App\Models\Admin\Index;
use App\Models\Admin\Super;
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

    public function get_info(Request $request){
        $id = $request->id;
        $result = Employee::get_info($id);
        if($result){
            return json_encode(['status'=>0,'msg'=>'success','result'=>$result]);
        }else{
            return json_encode(['status'=>1,'msg'=>'error']);
        }
    }

    public function upload_img(Request $request){
        $rlt = $this->upload_data($request);
        if ($rlt["success"] == false) {
            return json_encode($rlt);
        } else {
            return json_encode($rlt['message']);
        }
    }
    private function upload_data(Request $request)
    {
        if (!$request->hasFile('file')) {
            return [
                'success' => false,
                'message' => '上传文件为空'
            ];
        }
        $file = $request->file('file');
        if (!$file->isValid()) {
            return [
                'success' => false,
                'message' => '文件上传出错'
            ];
        }
        $extension = $file->getClientOriginalExtension();
        $storage_path = storage_path('app/public/img');//todo  这个路径不知道   在缓存里面
        if (!file_exists($storage_path)) {
            mkdir($storage_path, 0777, true);
        }
        $filename = md5("_" . millisecond()) . '.' . $extension;
        if ($file->move($storage_path, $filename) == false) {
            return [
                'success' => false,
                'message' => '文件保存失败'
            ];
        }
        return [
            'success' => true,
            'message' => $filename
        ];
    }

    public function edit(Request $request){
        $id = $request->id;
        $data = [
            'name'=>$request->name,
            'sex'=>$request->sex,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'img'=>$request->img,
            'card'=>$request->card
        ];
        $content = session('user')->name." 在 ".date('Y年m月d日 H点i分s秒',time()) ." 对".Employee::get_info($id)->name."的个人信息进行编辑";
        $result = Employee::edit($id,$data);
        Super::log(session('user')->id,$content);
        return json_encode(['status'=>0,'msg'=>'success','result'=>$result]);
    }

    public function del(Request $request){
        $id = $request->id;
        $content = session('user')->name." 在 ".date('Y年m月d日 H点i分s秒',time()) ." 对".Employee::get_info($id)->name."的信息进行删除";
        $result = Employee::del($id);
        Super::log(session('user')->id,$content);
        return json_encode(['status'=>0,'msg'=>'success','result'=>$result]);
    }

    public function reset(Request $request){
        $id = $request->id;
        $content = session('user')->name." 在 ".date('Y年m月d日 H点i分s秒',time()) ." 对".Employee::get_info($id)->name."的密码进行重置";
        $result = Employee::reset($id);
        Super::log(session('user')->id,$content);
        return json_encode(['status'=>0,'msg'=>'success','result'=>$result]);
    }

    public function add(Request $request){
        if(self::judge_user($request->user))
            return json_encode(['status'=>1,'msg'=>'该账号已存在!']);
        $data = [
            'name'=>$request->name,
            'sex'=>$request->sex,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'img'=>$request->img,
            'card'=>$request->card,
            'user'=>$request->user,
            'password'=>md5(md5('666666'))
        ];
        $content = session('user')->name." 在 ".date('Y年m月d日 H点i分s秒',time()) ." 添加店员 ".$request->name;
        $result = Employee::add($data);
        if($result){
            Super::log(session('user')->id,$content);
            return json_encode(['status'=>0,'msg'=>'添加成功!','result'=>$result]);
        }else{
            return json_encode(['status'=>1,'msg'=>'添加失败!','result'=>$result]);
        }
    }

    /*判断登陆账号是否存在*/
    public function judge_user($user){
        $result = Employee::judge_user($user);
        if($result){
            return true;
        }else{
            return false;
        }
    }
}