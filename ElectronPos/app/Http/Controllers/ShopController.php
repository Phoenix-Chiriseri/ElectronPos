<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view("pages.create-shop");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function viewShopList()
    {
        //return all the shops to the front end
        $shops = Shop::orderBy("id", "desc")->paginate(10);
        $numberOfShops = Shop::all()->count();
        return view("pages.shop-list")->with("shops",$shops)->with("numberOfShops",$numberOfShops);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //save the shop details
        $shop = Shop::create([
            'shop_name' => $request->shop_name,
            'email' => $request->shop_email,
            'shop_address' => $request->shop_address,
            'phone_number' => $request->phonenumber,
            'shop_city' => $request->shop_city,
        ]);
        return redirect("/dashboard");
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
