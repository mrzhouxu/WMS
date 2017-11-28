<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dealer;
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

    public function get_dealer_data(Request $request){
        $key = $request->key;
        $val = $request->val;
        $selType = $request->selType;
        $result = Goods::get_dealer_data($key,$val,$selType);
        $dealers = Dealer::get_data();
        foreach ($result as $g){
            foreach($dealers as $d){
                if($g->dealer_id == $d->id){
                    $g->dealer_name = $d->name;
                    $g->num = 0;
                    $g->phone = $d->phone;
                    $g->address = $d->address;
                }
            }
        }
        return json_encode(['status'=>0,'msg'=>'success','result'=>$result]);
    }

    public function dealer_send(Request $request){
        $dealer_commodity_id = $request->id;
        $address = $request->address;
        $dealer_id = $request->dealer_id;
        $dealer_name = $request->dealer_name;
        $img = $request->img;
        $in_price = $request->in_price;
        $name = $request->name;
        $num = $request->num;
        $out_price = $request->out_price;
        $phone = $request->phone;
        $status = $request->status;
        $type = $request->type;
        $unit = $request->unit;

        $goods_info = Goods::get_goods($dealer_commodity_id);
        $data = [
            'name'=>$name,
            'type'=>$type,
            'count'=>$num,
            'unit'=>$unit,
            'out_price'=>$out_price,
            'in_price'=>$in_price,
            'dealer_id'=>$dealer_id,
            'status'=>0,
            'img'=>$img,
            'dealer_commodity_id'=>$dealer_commodity_id
        ];
        if($goods_info){
            $data['count'] = $goods_info->count+$num;
            $result = Goods::update_goods($dealer_commodity_id,$data);
        }else{
            $result = Goods::add_goods($data);
        }

        if($result){
            return json_encode(['status'=>0,'msg'=>'success']);
        }else{
            return json_encode(['status'=>1,'msg'=>'失败']);
        }





    }


}