<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopCart;
use Illuminate\Http\Request;

class ShopCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = ShopCart::with(['customer', 'product'])->get();
        return response()->json($cartItems);
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
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:tb_customer,customer_id',
            'prod_id' => 'required|exists:tb_product,prod_id',
            'item_qty' => 'required|integer|min:1'
        ]);

        $cartItem = ShopCart::create($request->all());
        return response()->json($cartItem, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cartItem = ShopCart::with(['customer', 'product'])->findOrFail($id);
        return response()->json($cartItem);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'exists:tb_customer,customer_id',
            'prod_id' => 'exists:tb_product,prod_id',
            'item_qty' => 'integer|min:1'
        ]);

        $cartItem = ShopCart::findOrFail($id);
        $cartItem->update($request->all());
        return response()->json($cartItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cartItem = ShopCart::findOrFail($id);
        $cartItem->delete();
        return response()->json(null, 204);
    }

    public function getCustomerCart($custId)
    {
        $cartItems = ShopCart::with(['product'])
            ->where('cust_id', $custId)
            ->get();

        return response()->json($cartItems);
    }
}
