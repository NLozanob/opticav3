<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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
        $productCount = Product::where('status','=','1')->count();
        $date = Carbon::now();
        $date = $date->format('Y-m-d');
        $customerCount = Customer::where('status','=','1')->count();
        //$customerCount = DB::table('customers')->where('customers.date',$date)->get()->count("id");
        
        $saleCountDay = Sale::whereDate('sale_date', '=', Carbon::now()->format('Y-m-d'))->get()->count("id");
        $saleCountTotal = Sale::whereDate('sale_date', '=', Carbon::now()->format('Y-m-d'))->get()->sum("total_sale");

        $saleCountMes = Sale::whereMonth('sale_date', date('m'))->get()->count("id");
        $saleCountTotalMes = Sale::whereMonth('sale_date', date('m'))->get()->sum("total_sale");

    

        return view('home', compact('productCount','saleCountDay','saleCountTotal','customerCount', 'saleCountMes', 'saleCountTotal','saleCountTotalMes'));
    }
}
