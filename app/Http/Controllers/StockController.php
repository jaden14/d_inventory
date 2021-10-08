<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;

class StockController extends Controller
{
    public function __construct(Stock $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
    	$stock = $this->model->with('item.unit')->paginate(20);

        return view('stock.index',compact('stock'));
    }

    public function stock_edit(Request $request) {

        return $this->model->where('id', $request->id)->first();
    }

    public function store(Request $request)
    {
        $request->validate([
                'name' => 'required',
                'qty'  =>  'required',
            ]);

            $stock['name'] = $request->name;
            $stock['qty'] = $request->qty;
            $stock['status'] = 'Available';

            $stocks = Stock::create($stock);

            return $stocks;
    }

    public function stock_update(Request $request) 
    {
        $request->validate([
                'name' => 'required',
                'qty'  =>  'required',
            ]);
        $stock = $this->model->where('id', $request->id)->first();
        if($request->qty == 0){
            $request['status'] = 'Out of Stocks';
            $stock->update($request->all());
        } else {
            $request['status'] = 'Available';
            $stock->update($request->all());
        }


        return $stock;
    }
}
