<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'available' => ['required', 'boolean', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);
    }

    public function index()
    {
       return view('table');
    }

    public function loadSeats()
    {
        return $seats = Table::all();
    }

    public function getSeatTable()
    {
        return $seatTables = Table::orderBy('id', 'desc')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        Table::create($request->all());
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *  @param Table $seatTable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $seatTable)
    {
        $this->validator($request->all())->validate();
        $seatTable->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *@param Table $seatTable
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $seatTable)
    {
        $seatTable->delete();
    }
}
