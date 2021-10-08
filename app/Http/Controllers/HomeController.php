<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Stock;
use App\Release;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $item = Item::sum('qty');

        $items =Item::where('status','Pending')->count();

        $stock = Stock::where('status','Available')->sum('qty');

        $stocks = Stock::where('status','Out of Stocks')->count();

        $release = Release::where('status','Released')->sum('qty');

        $released = Release::where('status','for Release')->count();

        return view('home', compact('item','stock','release','items','stocks','released'));
    }
}
