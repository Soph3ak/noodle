<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Phone;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'address' => ['required',],
        ]);
    }

    protected function phone_validator(array $data)
    {
        return Validator::make($data, [
            'phone_number' => ['required', 'string', 'max:255'],
            'shop_id' => ['required'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('shop');
    }
    public function getPhones()
    {
        return $phones = Phone::all();
    }

    public function getShop()
    {
        return $shop = Shop::first();
    }

    public function test(Request $request)
    {
        foreach ($request->f_phones as $req){
            $this->phone_validator($req)->validate();

            $i = $req['id'];
            $num = $req['phone_number'];
            $count = Phone::where('id',$i)->count();
            if ($count>0) {
                Phone::where('id',$i)
                    ->update(['phone_number' => $num]);
            }
           else {
               $phone = new Phone([
                   'phone_number' => $req['phone_number'],
                   'shop_id' => $req['shop_id'],
               ]);

               $phone->save();
           }

        }
        return response()->json('Phone updated success!');

    }


    /**ta
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Shop $shop
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Shop $shop)
    {
        $this->validator($request->all())->validate();
        $shop->update($request->all());
        return response()->json($request,'200');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function destroy_phone(Request $request)
    {
      /*  return response()->json($id);*/

        foreach ($request->d_phones as $req){
            $i = $req['id'];
            if(Phone::find($i)){
                Phone::findOrFail($i)->delete();
            }

           /* Phone::findOrFail($i)->delete();*/
        }
        return response()->json('Phone Number Deleted');

        /*foreach ($request->f_phones as $req){}
        return $phone;
        $phone->delete();*/
    }
}
