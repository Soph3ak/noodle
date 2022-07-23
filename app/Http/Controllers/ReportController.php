<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Table;
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
        return $sellers = User::select('id','name_kh', 'photo')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getCustomers(){
        //Get only customers has orders
        return $customers = Customer::select('id','name')
            ->whereHas('orders')
            ->orderBy('name', 'asc')
            ->get();
    }


    public function getReport(Request $request){

        /*return $result = Order::crossJoin('products')
            ->get();*/

        $payments = $request->paymentTypes;
        $searchTitle = $request->title;
        $tables = $request->tables;
        $sellers = $request->sellers;
        $customers = $request->customers;
        $orderBy = $request->orderBy;

        $reports = Order::whereDate('created_at', '>=', Carbon::createFromDate($request->start))
            ->whereDate('created_at', '<=', Carbon::createFromDate($request->end))
            ->with('user:id,name_kh,photo')
            ->with('customer:id,name')
            ->with('table:id,name')
            ->with('shop:id,name') /*(user, customer, table, shop) is function's name in their modal*/
            ->with('payment:id,payment')
            ->with('products' , function($query){
                //To select nothing, We need only empty products[] in reports to push data in later
                $query->where('id',0);

            });

        if($orderBy != ''){
            $sort_by = $orderBy[0];
            $direction = $orderBy[1];
            switch ($sort_by){
                case 'id':
                    $reports = $reports->orderBy('id', $direction);
                    break;

                case 'date':
                    $reports = $reports->orderBy('created_at', $direction);
                    break;

                case 'customer':
                    $reports = $reports->orderBy(Customer::select('name')->whereColumn('customers.id','orders.customer_id'),$direction);
                    break;

                case 'seller':
                    $reports = $reports->orderBy(User::select('name')->whereColumn('users.id','orders.user_id'),$direction);
                    break;

                case 'table':
                    $reports = $reports->orderBy(Table::select('name')->whereColumn('tables.id','orders.table_id'),$direction);
                    break;

                case 'payment':
                    $reports = $reports->orderBy(Payment::select('payment')->whereColumn('payments.id','orders.payment_id'),$direction);
                    break;

                case 'subtotal':
                    $reports = $reports->orderBy('subtotal', $direction);
                    break;

                case 'discount':
                    $reports = $reports->orderBy('discount', $direction);
                    break;

                case 'total':
                    $reports = $reports->orderBy('total', $direction);
                    break;


                default:

            }


        }

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

        /*SELLER FILTER*/
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

        /*CUSTOMER FILER*/
        if($customers != ''){
            foreach ($customers as $customer){
                if($customer === 'all')
                    break;
                else{
                    $reports = $reports->whereIN('customer_id',$customers); //customer_id is a column in table orders
                    break;
                }
            }
        }
        else
            $reports = $reports->where('customer_id','');
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
