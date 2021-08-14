<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_id' => ['required', 'numeric'],
            'customer_id' => ['required', 'numeric'],
            'table_id' => ['required', 'numeric'],
            'shop_id' => ['required', 'numeric'],
            'payment_id' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
        ]);
    }

    public function saveOrder(Request $request){
        return $request;

        $this->validator($request->all())->validate();
        $order = Order::create($request->all());

        $data = array();
        foreach ($request->order as $ord){
            $nest = array();
            $nest['order_id'] = $order->id;
            $nest['product_id'] = $ord['id'];
            $nest['quantity'] = $ord['qty'];
            $nest['unit_price'] = $ord['price'];
            $nest['amount'] = $ord['amount'];
            $nest['sub_discount'] = $ord['discount'];

            $data[] = $nest;
        }
        $order->products()->sync($data);
        return $data;

    }
}
