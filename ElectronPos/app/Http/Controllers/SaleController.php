<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Product;
use App\Models\CompanyData;
use App\Models\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Models\Stock;
use App\Models\User;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\BluetoothPrintConnector;
use Illuminate\Support\Facades\Session;

class SaleController extends Controller
{
    
     public function index()
    {
        //return the sales to the view-sales blade file
        $sales = Sales::leftJoin('users', 'sales.user_id', '=', 'users.id')
        ->select('users.name', 'sales.*')
        ->orderBy('sales.id', 'desc')
        ->paginate(5);
        $numberOfSales = Sales::all()->count();
        return view("pages.view-sales")->with("sales",$sales)->with("numberOfSales",$numberOfSales);
    }

    public function doTransaction(Request $request) {
        $userId = Auth::user()->id;
        $paymentMethod = $request->input("payment_method");
        //dd($paymentMethod);
        $total = $request->input('total');
        $change = $request->input('change');
        $amountPaid = $request->input('amountPaid');
        $customerId = $request->input('customerId');
        $tableDataJson = $request->input('table_data');
        $companyDetails = CompanyData::latest()->first();
    
        // Decode the JSON string into a PHP array
        $tableData = json_decode($tableDataJson, true);      
    
        // Create a new sale record
        $sale = Sales::create([
            'total' => $total,
            'change' => $change,
            'amountPaid' => $amountPaid,
            'user_id' => $userId,
            'payment_method' => $paymentMethod // Add payment method here
        ]);
    
        // Iterate through each item in the sale and associate it with the sale record
        foreach ($tableData as $item) {
            $productId = $item['id'];
            $quantitySold = $item['quantity'];
    
            // Update the available quantity in the stocks table
            Stock::where('product_id', $productId)
                ->decrement('quantity', $quantitySold);
    
            // Associate the sold product with the sale
            $sale->products()->attach($productId, ['quantity' => $quantitySold]);
        }
    
        // Generate invoice HTML
        $invoiceHtml = view('pages.salesInvoice', [ // ensure the correct view path
            'sale' => $sale,
            'customer' => Customer::find($customerId),
            'items' => $tableData,
            'details' => $companyDetails,
            'amountPaid' => $amountPaid,
            'paymentMethod' => $paymentMethod // Include payment method in the view
        ])->render();
    
        // Save the invoice HTML
        $invoice = Invoice::create([
            'html' => $invoiceHtml,
            'user_id' => $userId
        ]);
    
        // Associate the invoice with the sale
        $sale->invoice_id = $invoice->id;
        $sale->save();
    
        // Return the view with the $invoiceHtml variable
        return view('pages.salesInvoice', [
            'sale' => $sale,
            'customer' => Customer::find($customerId),
            'items' => $tableData,
            'details' => $companyDetails,
            'amountPaid' => $amountPaid,
            'paymentMethod' => $paymentMethod // Pass payment method to the view
        ]);
    }

    public function create()
    {
        //
    }


    public function show(Sale $sale)
        {
            
            //
        
        }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}