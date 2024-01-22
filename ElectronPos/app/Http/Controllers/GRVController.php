<?php

namespace App\Http\Controllers;

use App\Models\GRV;
use App\Models\Stock;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade;


class GRVController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createGRN(){
        
        
        $grvs = GRV::join('suppliers', 'g_r_v_s.supplier_id', '=', 'suppliers.id')
        ->leftJoin('stocks', 'g_r_v_s.id', '=', 'stocks.grv_id')
        ->leftJoin('shops', 'g_r_v_s.shop_id', '=', 'shops.id')
        ->select('g_r_v_s.*', 'suppliers.supplier_name', 'stocks.product_name', 'shops.shop_name')
        ->orderBy("g_r_v_s.id", "desc")
        ->paginate(10);
        return view("pages.create-grn")->with("grvs",$grvs);
    }

    public function generateGrv(){
    {

        $pdf = PDF::loadView('pages.generate_grv');
        return $pdf->download('receipt.pdf');
        }
    }

    public function viewById($id){

        $email = auth()->user()->email;
        $grv = GRV::join('suppliers', 'g_r_v_s.supplier_id', '=', 'suppliers.id')
        ->leftJoin('stocks', 'g_r_v_s.id', '=', 'stocks.grv_id')
        ->leftJoin('shops', 'g_r_v_s.shop_id', '=', 'shops.id')
        ->select('g_r_v_s.*', 'suppliers.supplier_name', 'stocks.product_name', 'shops.shop_name')
        ->find($id);  // Use find directly to fetch a single record by ID
        return view("pages.view-grv")->with("grv",$grv)->with("email",$email);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function submitGrv(Request $request)
    {

        
        $grv = new GRV(); // Use the GRV model
        $grv->grvNumber = $this->generateGRNNumber();
        $grv->total = $request->input("total");
        $grv->supplier_id = $request->input('supplier_id');
        $grv->shop_id = $request->input('shop_id');
        $grv->grn_date = $request->input('grn_date');
        $grv->payment_method = $request->input('payment_method');
        $grv->additional_information = $request->input('additional_information');
        $grv->supplier_invoicenumber = $request->input('supplier_invoicenumber');
        $grv->additional_costs = $request->input('additional_costs');
        $grv->save();
        
        // Save the table data
        $tableData = $request->input('table_data');
        foreach ($tableData as $rowData) {
            $tableRow = new Stock(); // Use the Stock model
            $tableRow->product_name = $rowData['product_name'];
            $tableRow->measurement = $rowData['measurement'];
            $tableRow->quantity = $rowData['quantity'];
            $tableRow->unit_cost = $rowData['unit_cost'];
            $tableRow->total_cost = $rowData['total_cost'];
            $tableRow->grv_id = $grv->id; // Assuming you have a foreign key in the Stock model linking to the main GRV table
            $tableRow->save();
        }
        // Redirect or respond with success message
        //return redirect()->route('/dashboard')->with('status', 'GRV submitted successfully');
        return view('pages.view-gnn-result')->with('grv', $grv);
    }

    public function generateGRNNumber()
{
    // Check if the counter is already set in the session, if not, initialize it
    if (!Session::has('grn_counter')) {
        Session::put('grn_counter', 1);
    } else {
        // Increment the counter
        Session::put('grn_counter', Session::get('grn_counter') + 1);
    }
    // Format the counter with leading zeros
    $formattedCounter = str_pad(Session::get('grn_counter'), 4, '0', STR_PAD_LEFT);
    // Concatenate the parts to create the GRN number
    $grvNumber = 'GRN-' . $formattedCounter;
    return $grvNumber;
}

    /**
     * Display the specified resource.
     */
    public function show(GRV $gRV)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GRV $gRV)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GRV $gRV)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GRV $gRV)
    {
        //
    }
}
