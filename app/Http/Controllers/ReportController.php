<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ReportController extends Controller
{
    public function index(){
        return view('report');
    }

    public function getPaymentType(){
        return $payment = Payment::select('id','payment')->get();
    }

    public function getSellers(){
        return $sellers = User::select('id','name_kh', 'photo')->get();
    }


    public function getReport(Request $request){

        /*return $result = Order::crossJoin('products')
            ->get();*/

        $payments = $request->paymentTypes;
        $searchTitle = $request->title;
        $tables = $request->tables;
        $sellers = $request->sellers;

        $reports = Order::whereDate('created_at', '>=', Carbon::createFromDate($request->start))
            ->whereDate('created_at', '<=', Carbon::createFromDate($request->end))
            ->with('user:id,name_kh,photo')
            ->with('customer:id,name')
            ->with('table:id,name')
            ->with('shop:id,name') /*(user, customer, table, shop) is function's name in their modal*/
            ->with('payment:id,payment')
            ->with('products' , function($query){
                $query->where('id',0);//To select nothing
            })

            ->orderBy('id', 'desc');
            /*TABLE SORT*/


            /*END TABLE SORT*/
        /*Payment FILTER*/
        if($payments != ''){
            foreach ($payments as $pay){
                if($pay === 'all')
                    break;
                else{
                    $reports = $reports->whereIN('payment_id',$payments);
                    break;
                }
            }
        }
        else
            $reports = $reports->where('payment_id','');
        /*END Payment FILTER*/



        if($searchTitle != '')
            $reports = $reports->where('id','like','%'.$searchTitle.'%');



        /*TABLE FILTER*/
        if($tables != ''){
            foreach ($tables as $tbl){
                if($tbl === 'all')
                    break;
                else{
                    $reports = $reports->whereIN('table_id',$tables);
                    break;
                }
            }
        }
        else
            $reports = $reports->where('table_id','');
        /*END TABLE FILTER*/

        /*TABLE SELLER*/
        if($sellers != ''){
            foreach ($sellers as $seller){
                if($seller === 'all')
                    break;
                else{
                    $reports = $reports->whereIN('user_id',$sellers);
                    break;
                }
            }
        }
        else
            $reports = $reports->where('user_id','');
        /*END SELLER FILTER*/


        return $reports->paginate($request->size);

    }

    public function getOrderProducts(Request $request){
        $order = Order::find($request->orderID);

        $collector = collect();
        foreach ($order->products as $product){
            $collector->push($product);
        }
        $count = $collector->count();
        return [$collector->take($request->limit), 'total' => $count];

    }
}
