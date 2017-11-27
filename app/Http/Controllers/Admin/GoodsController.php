<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Goods;
use Illuminate\Http\Request;
use DB;

class GoodsController extends Controller
{
    public function index(){ }

    public function get_type_data(Request $request){
        $name = $request->val;
        $result = Goods::get_type_data($name)->toArray();
        return json_encode(['status'=>0,'msg'=>'success','result'=>$result]);
    }

    public function _id_get_data(Request $request){
        $id = $request->id;
        $result = Goods::_id_get_type_data($id);
        return json_encode(['status'=>0,'msg'=>'success','result'=>$result]);
    }

    public function add_type(Request $request){
        $typeName = $request->typeName;
        $result = Goods::add_type($typeName);
        if($result){
            return json_encode(['status'=>0,'msg'=>'添加成功!','result'=>$result]);
        }
        return json_encode([['status'=>1,'msg'=>'添加失败!','result'=>$result]]);
    }

    public function edit_type(Request $request){
        $id = $request->id;
        $name = $request->name;
        $data = [
            'name'=>$name
        ];
        $result = Goods::edit_type($id,$data);
        if($result){
            return json_encode(['status'=>0,'msg'=>'编辑成功!','result'=>$result]);
        }
        return json_encode([['status'=>1,'msg'=>'编辑失败!','result'=>$result]]);
    }

    public function del_type(Request $request){
        $id = $request->id;
        $result = Goods::del_type($id);
        if($result){
            return json_encode(['status'=>0,'msg'=>'删除成功!','result'=>$result]);
        }
        return json_encode([['status'=>1,'msg'=>'删除失败!','result'=>$result]]);
    }
}