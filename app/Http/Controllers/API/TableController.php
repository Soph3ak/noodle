<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable','string', 'max:255'],
        ]);
    }

    public function index()
    {
       return view('table');
    }

    public function loadSeats()
    {
        return $seats = Table::select('id', 'name')->get();
    }

    public function getSeatTable()
    {
        return $seatTables = Table::orderBy('id', 'asc')
            ->paginate(10);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
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
     * @param \Illuminate\Http\Request $request
     * @param Table $seatTable
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Table $seatTable, $id)
    {
        $this->validator($request->all())->validate();
        $seatTable->findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *@param Table $seatTable
     * @return void
     * @throws \Exception
     */
    public function destroy(Table $seatTable, $id)
    {
        $seatTable->findOrFail($id)->delete();
    }
}
