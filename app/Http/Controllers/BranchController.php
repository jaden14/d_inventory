<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;

class BranchController extends Controller
{
    public function __construct(Branch $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {
    	$branch = $this->model->paginate(20);

        return view('branch.index',compact('branch'));
    }

    public function search(Request $request)
    {
    	if($request->branch) {

    		$branch = $this->model->Where('name', 'like', '%' . $request->branch . '%');
    	}

    	if( $request->branch == null) {

            return redirect('/branch');
        }

    	$branch = $branch->paginate(20);
        return view('branch.index',compact('branch'));
    }

    public function store(Request $request)
    {
    	$request->validate([
                'name'  =>  'required',
            ]);

    	return $this->model->create($request->all());
    }

    public function branch_edit(Request $request) {

        return $this->model->where('id', $request->id)->first();
    }

    public function branch_update(Request $request) 
    {
        $request->validate([
                'name'  =>  'required',
            ]);

        $branch = $this->model->where('id', $request->id)->first();

        $branch->update($request->all());

        return $branch;
    }

    public function branch_delete(Request $request) 
    {
        $data = $this->model->where('id', $request->id)->first();
        
        $data->delete();

        return $data;
    }
}
