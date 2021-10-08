<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    public function __construct(User $model)
    {
    	$this->model = $model;
        $this->middleware('auth');
    }

    public function index()
    {

        return view('user.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:250'],
            'email' => ['required', 'string', 'max:255', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' =>['required'],
        ]);
       
        User::create([            
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role' => $request['role'],
        ]);

            return back()->with('success', 'New User Added!');
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);

            return view('user.edit', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find(auth()->user()->id);
        $validate = $request->validate([
           'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (Hash::check($request->current_password, $user->password) && $request->password == $request->password_confirmation) {
            $user->password = bcrypt($request->password);
            $user->update();

            return back()->with('success', 'Password Changed');
        } else {
            return back()->with('delete', 'Current Password Not match!!');
        }
    }
}
