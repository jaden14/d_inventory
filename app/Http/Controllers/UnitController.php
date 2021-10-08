<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;

class UnitController extends Controller
{
    public function __construct(Unit $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
    	$unit = $this->model->paginate(20);

        return view('unit.index',compact('unit'));
    }

    public function search(Request $request)
    {
    	if($request->unit) {

    		$unit = $this->model->Where('name', 'like', '%' . $request->unit . '%');
    	}

    	if( $request->unit == null) {

            return redirect('/unit');
        }

    	$unit = $unit->paginate(20);
        return view('unit.index',compact('unit'));
    }

    public function store(Request $request)
    {
    	$request->validate([
                'name'  =>  'required',
            ]);

    	return $this->model->create($request->all());
    }

    public function unit_edit(Request $request) {

        return $this->model->where('id', $request->id)->first();
    }

    public function unit_update(Request $request) 
    {
        $request->validate([
                'name'  =>  'required',
            ]);

        $unit = $this->model->where('id', $request->id)->first();

        $unit->update($request->all());

        return $unit;
    }

    public function unit_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();
        
        $data->delete();

        return $data;
    }
}
