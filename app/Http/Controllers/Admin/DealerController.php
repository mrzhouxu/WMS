<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Dealer;
use App\Models\Admin\Index;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    public function index(){

    }

    public function get_data(Request $request){
        $key = $request->key;
        $val = $request->val;
        $result = Dealer::get_data($key,$val);
        foreach ($result as $item ){
            $products = Dealer::get_product($item->id);
            $temp_arr = [];
            foreach ($products as $p){
                array_push($temp_arr,[$p->img,$p->name]);
            }
            $item->products = $temp_arr;
        }
        return json_encode(['status'=>0,'msg'=>'success','result'=>$result->toArray()]);
    }

    public function add(Request $request){
        $name = $request->name;
        $phone = $request->phone;
        $address = $request->address;
        $product_all = $request->product_all;
        $id = Dealer::add_dealer_get_id($name,$phone,$address);
        if($id){
            if($product_all){
                foreach ($product_all as $item){
                    Dealer::add_dealer_product($id,$item['name'],$item['type'],$item['in_price'],$item['out_price'],$item['unit'],$item['img']);
                }
            }
            return json_encode(['status'=>0,'msg'=>'success','result'=>$product_all]);
        }else{
            return json_encode(['status'=>1,'msg'=>'经销商添加失败','result'=>$id]);
        }
    }

    public function get_info(Request $request){
        $id = $request->id;
        $info = Dealer::get_info($id);
        if($info){
            $products = Dealer::get_product($id);
            return json_encode(['status'=>0,'msg'=>'success','info'=>$info,'products'=>$products]);
        }else{
            return json_encode(['status'=>1,'msg'=>'该经销商已不存在']);
        }
    }

    public function edit(Request $request){
        $id = $request->id;
        $name = $request->name;
        $phone = $request->phone;
        $address = $request->address;
        $product_all = $request->product_all;
        $info = [
            'name'=>$name,
            'phone'=>$phone,
            'address'=>$address
        ];
        Dealer::update_dealer_info($id,$info);
        if($product_all){
            foreach ($product_all as $item){
                $product_info = [
                    'name'=>$item['name'],
                    'type'=>$item['type'],
                    'in_price'=>$item['in_price'],
                    'out_price'=>$item['out_price'],
                    'unit'=>$item['unit'],
                    'img'=>$item['img'],
                    'status'=>$item['status']
                ];
                if(isset($item['id'])){
                    Dealer::update_dealer_product($item['id'],$product_info);
                }else{
                    Dealer::add_dealer_product($id,$item['name'],$item['type'],$item['in_price'],$item['out_price'],$item['unit'],$item['img']);
                }
            }
        }
        return json_encode(['status'=>0,'msg'=>'success']);
    }

    public function del(Request $request){
        $id = $request->id;
        $result = Dealer::del($id);
        return json_encode(['status'=>0,'msg'=>'success','result'=>$result]);
    }

}