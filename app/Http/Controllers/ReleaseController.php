<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Release;
use Carbon\Carbon;
use App\Stock;
use App\Unit;
use App\Branch;
use Auth;

class ReleaseController extends Controller
{
    public function __construct(Release $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
    	$release = $this->model->with('branch','stock','unit')->where('status', 'for Release')->where('user_id', auth::user()->id)->paginate(40);

    	$date = Carbon::now();
    	$stock = Stock::orderBy('name','asc')->get();
    	$unit = Unit::orderBy('name','asc')->get();
    	$branch = branch::orderBy('name','asc')->get();

    	$released = $this->model->where('status','for Release')->where('user_id', auth::user()->id)->sum('qty');

        return view('release.index',compact('release','date','stock','unit','branch','released'));
    }

    public function history(Request $request)
    {
    	$branch = branch::orderBy('name','asc')->get();
        $release = $this->model->with('unit','stock','branch')->where('status','Released')->paginate(20);

        return view('release.show',compact('release','branch'));
    }

    public function history_search(Request $request)
    {
        $item = $request->item;
        $branched = $request->branch;
        $branch = branch::orderBy('name','asc')->get();

        if($request->date) {

            $release = $this->model->Where('date', 'like', '%' . $request->date . '%');
        }

        if($request->item) {

            $release = $this->model->WhereHas('stock', function ($q) use ($item) {
                    return $q->where('name', $item);
            });
        }

        if($request->branch) {

            $release = $this->model->WhereHas('branch', function ($q) use ($branched) {
                    return $q->where('name', $branched);
            });
        }

        if( $request->date && $request->branch) {

            $release = $this->model->Where('date', 'like', '%' . $request->date . '%')->WhereHas('branch', function ($q) use ($branched) {
                    return $q->where('name', $branched);
            });
        }

        if( $request->date && $request->item) {

            $release = $this->model->Where('date', 'like', '%' . $request->date . '%')->WhereHas('stock', function ($q) use ($item) {
                    return $q->where('name', $item);
            });
        }

        if( $request->branch && $request->item) {

            $release = $this->model->WhereHas('branch', function ($q) use ($branched) {
                    return $q->where('name', $branched);
            })->WhereHas('stock', function ($q) use ($item) {
                    return $q->where('name', $item);
            });
        }

        if( $request->date == null && $request->branch == null && $request->item == null) {

            return redirect('/release.history');
        }

        $release = $release->paginate(20);
        return view('release.show', compact('release','branch'));

    }

    public function print(Request $request)
    {
        $date = $request->date;
    	$release = $this->model->with('branch','stock','unit')->where('status', 'for Release')->where('date', $request->date)->orderBy('branch_id','asc')->get()->groupBy('branch_id');
        $status = 'For Release';

        return view('release.print',compact('release','date','status'));
    }

    public function printed(Request $request)
    {
        $date = $request->date;
        $release = $this->model->with('branch','stock','unit')->where('status', 'Released')->where('date', $request->date)->orderBy('branch_id','asc')->get()->groupBy('branch_id');

        $status = 'Released';

        return view('release.print',compact('release','date','status'));
    }

    public function stock(Request $request){
    
        //if our chosen id and products table prod_cat_id col match the get first 100 data 

        //$request->id here is the id of our chosen option id
        $data=Stock::select('qty','status')->where('id',$request->id)->first();
        return response()->json($data);//then sent this data to ajax success
    }

    public function store(Request $request)
    {
        $request->validate([
                'quantity' => 'gte:qty',
                'qty' => 'required|numeric|min:1',
                'date' => 'required',
                'branch_id' => 'required',
                'stock_id' => 'required',
                'unit_id' => 'required',
                
            ]);

        $stock = Stock::where('id', $request->stock_id)->first();
        $stock->qty = $request->quantity - $request->qty;
        $stock->update();

        $release['date'] = $request->date;
        $release['user_id'] = $request->user_id;
        $release['stock_id'] = $request->stock_id;
        $release['branch_id'] = $request->branch_id;
        $release['unit_id'] = $request->unit_id;
        $release['qty'] = $request->qty;
        $release['status'] = 'for Release';

        $release = $this->model->create($release);

        if($stock->qty == 0){
            $stock->status = 'Out of Stocks';
            $stock->update();
        }
        return $release;
    }

    public function release_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();

        $stock = Stock::where('id', $data->stock_id)->first();
        $stock->qty = $stock->qty + $data->qty;
        $stock->status = 'Available';
        $stock->update();
        
        $data->delete();

        return $data;
    }

    public function deliver(Request $request)
    {  
        $release = $this->model->where('date', $request->date)->where('user_id', $request->id)->where('status', 'for Release')->update(['status' => 'Released']);

        return $release;

    }
}
