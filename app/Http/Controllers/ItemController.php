<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Auth;
use Carbon\Carbon;
use App\Unit;
use App\Stock;

class ItemController extends Controller
{
    public function __construct(Item $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
        $stock = Stock::orderBy('name','asc')->get();
        $date = Carbon::now();
        $unit = Unit::orderBy('name','asc')->get();
    	$item = $this->model->with('unit','stock')->where('status','Pending')->where('user_id', auth::user()->id)->paginate(20);

        $total = $this->model->where('status','Pending')->where('user_id', auth::user()->id)->sum('amount');

        return view('item.index',compact('item','date','unit','stock','total'));
    }

    public function history(Request $request)
    {
        $item = $this->model->with('unit','stock')->where('status','Completed')->paginate(20);

        return view('item.show',compact('item'));
    }

    public function history_search(Request $request)
    {
        $search = $request->item;

        if($request->date) {

            $item = $this->model->Where('date', 'like', '%' . $request->date . '%');
        }

        if($request->item) {

            $item = $this->model->WhereHas('stock', function ($q) use ($search) {
                    return $q->where('name', $search);
            });
        }

        if( $request->date && $request->item) {

            $item = $this->model->Where('date', 'like', '%' . $request->date . '%')->WhereHas('stock', function ($q) use ($search) {
                    return $q->where('name', $search);
            });
        }

        if( $request->date == null && $request->item == null ) {

            return redirect('/item.history');
        }

        $item = $item->paginate(20);
        return view('item.show', compact('item'));

    }

    public function store(Request $request)
    {
        $request->validate([
                'date' => 'required',
                'qty'  =>  'required',
                'price'  =>  'required',
                'unit_id'  =>  'required',
            ]);

        if($request->item_name != null) {
            $stock['name'] = $request->item_name;
            $stock['qty'] = 0;
            $stock['status'] = 'Out of Stocks';

            $stocks = Stock::create($stock);

            $s_id = $stocks->id;

            $item['stock_id'] = $s_id;
            $item['qty'] = $request->qty;
            $item['unit_id'] = $request->unit_id;
            $item['price'] = $request->price;
            $item['amount'] = $request->amount;
            $item['date'] = $request->date;
            $item['status'] = 'Pending';
            $item['user_id'] = $request->user_id;

            return $this->model->create($item);

        } else {
            $item['stock_id'] = $request->stock_id;
            $item['qty'] = $request->qty;
            $item['unit_id'] = $request->unit_id;
            $item['price'] = $request->price;
            $item['amount'] = $request->amount;
            $item['date'] = $request->date;
            $item['status'] = 'Pending';
            $item['user_id'] = $request->user_id;

            return $this->model->create($item);
        }

        
    }

    public function item_edit(Request $request) {

        return $this->model->with('unit','stock')->where('id', $request->id)->first();
    }

    public function item_update(Request $request) 
    {
        $request->validate([
                'date' => 'required',
                'qty'  =>  'required',
                'price'  =>  'required',
                'unit_id'  =>  'required',
            ]);

        $branch = $this->model->where('id', $request->id)->first();

        $branch->update($request->all());

        return $branch;
    }

    public function item_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();
        
        $data->delete();

        return $data;
    }

    public function item_stock(Request $request)
    {
        $items = $this->model->where('user_id', $request->id)->where('status','Pending')->first();

        $itemss = $this->model->where('user_id', $request->id)->where('status','Pending')->get();
        
        $item = $this->model->where('user_id', $items->user_id)->where('status', 'Pending')->update(['status' => 'Completed']);

        foreach ($itemss as $stock) {

        $stocks = Stock::find($stock->stock_id);

        $stocks->qty = $stocks->qty + $stock->qty;
        $stocks->status = 'Available';
        $stocks->update();
        }

        return $item;

    }
}
