<?php

namespace App\Http\Controllers;

use App\Models\Order;

class PrintController extends Controller
{
    public function print($id){
        $order = Order::where('id',$id)
            ->with('shop:id,name_kh,name,address,address_kh') //make sure no space 'shop:id,name_kh,name,address,address_kh'
            ->with('customer:id,name,address,phone')
            ->with('table:id,name')
            ->with('user:id,name_kh')
            ->with('products')
            ->get();
        return view('invoice-layout1', ['order'=>array($order)]);
    }
}
