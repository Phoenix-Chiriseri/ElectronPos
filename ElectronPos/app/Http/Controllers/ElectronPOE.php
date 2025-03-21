<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Rate;
use App\Models\Customer;
use App\Models\PaymentTypes;
use App\Http\Requests\SaleRequest;
use App\Models\Product;
use App\Models\Sales;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Response;


class ElectronPOE extends Controller
{
    
    //show the products and customers on the front end of the point of sale application 
    public function index()
    {
        $customers = Customer::orderBy('id', 'DESC')->get();
        $paymentTypes = PaymentTypes::orderBy("id","desc")->get();
        $products = Product::orderBy('name', 'DESC')->get();
        //Total of sales today
        $totalSalesPerDay = 0;
        $salesToday = Sales::select('total')->where('created_at', date('Y-m-d'))
            ->get();
        //add the number to the total amount and return to the blade view
        foreach ($salesToday as $sale) {
            $totalSalesPerDay += $sale->total;
        }
        return view(
            'pages.cart.index',
            compact('customers', 'products', 'totalSalesPerDay','paymentTypes')
        );
    }  

    public function zigScreen()
    {
        $customers = Customer::orderBy('id', 'DESC')->get();
        $currentRate = Rate::latest()->first();
        $rate = $currentRate["setRate"];
        //Get the products information
        //Get the products information
        $products = Product::orderBy('name', 'DESC')->get();
        //Total of sales today
        $totalSalesPerDay = 0;
        $salesToday = Sales::select('total')->where('created_at', date('Y-m-d'))
            ->get();
        //add the number to the total amount and return to the blade view
        foreach ($salesToday as $sale) {
            $totalSalesPerDay += $sale->total;
        }
        return view(
            'pages.cart.zig-screen',
            compact('customers', 'products', 'totalSalesPerDay','rate')
        );
    }  
    //return the total sales for the entire day
}
