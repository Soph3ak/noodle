<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Utils;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer');
    }

    public function getCustomers(Request $request)
    {
        $searchTitle = $request->title;
        $limit = $request->limit;
        $orderBy = $request->orderBy;

        $customers = Customer::with('latestOrder')
            ->with('orders' , function($query){
                //To select nothing, We need only empty orders[] in customer to push data in later
                $query->where('id',0);
            });

        if($orderBy != ''){
            $sort_by = $orderBy[0];
            $direction = $orderBy[1];
            switch ($sort_by){
                case 'id':
                    $customers = $customers->orderBy('id', $direction);
                    break;

                case 'name':
                    $customers = $customers->orderBy('name', $direction);
                    break;

                default:
                    $customers = $customers->orderBy('id', 'desc');
            }
        }
        return $customers->paginate($request->size);
    }

    protected function getCustomerOrders(Request $request)
    {
         $orders = Customer::find($request->cusID)->orders()
            ->with('user:id,name_kh,photo')
            ->with('table:id,name')
            ->with('payment:id,payment')
            ->orderBy('created_at','desc')
            ->get();

        $collector = collect();
        foreach ($orders as $order){
            $collector->push($order);
        }
        $count = $collector->count();
        return [$collector->take($request->limit), 'total' => $count];
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        Customer::create($request->all());

        /*return ['message'=>'Created successfully'];*/

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Customer $customer)
    {
        $this->validator($request->all())->validate();
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        /*return ['message'=>'Deleted success'];*/
    }
}
