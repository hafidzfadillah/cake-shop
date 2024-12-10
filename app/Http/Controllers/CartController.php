<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShopCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;

        if (!$customer) {
            return redirect()->route('home')->with('error', 'Customer profile not found. Please contact support.');
        }

        $cartItems = ShopCart::where('cust_id', $customer->cust_id)
            ->with('product', function ($query) {
                $query->withTrashed();
            })
            ->get();

        $total = $cartItems->sum(function($item) {
            if (!$item->product || $item->product->deleted_at) {
                return 0;
            }
            return $item->item_qty * ($item->product->prod_price_promo != 0 ? $item->product->prod_price_promo : $item->product->prod_price);
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'prod_id' => 'required|exists:tb_product,prod_id',
            'item_qty' => 'required|integer|min:1'
        ]);

        $customer = Auth::user()->customer;

        if (!$customer) {
            return back()->with('error', 'Customer profile not found. Please contact support.');
        }

        $product = Product::findOrFail($request->prod_id);

        if ($product->prod_stock < $request->item_qty) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem = ShopCart::updateOrCreate(
            [
                'cust_id' => $customer->cust_id,
                'prod_id' => $request->prod_id,
            ],
            [
                'item_qty' => $request->item_qty,
                'created_at' => now()
            ]
        );

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_qty' => 'required|integer|min:1'
        ]);

        $cartItem = ShopCart::findOrFail($id);

        if ($cartItem->product->prod_stock < $request->item_qty) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem->update([
            'item_qty' => $request->item_qty
        ]);

        return back()->with('success', 'Cart updated successfully!');
    }

    public function destroy($id)
    {
        $cartItem = ShopCart::findOrFail($id);
        $cartItem->delete();

        return back()->with('success', 'Item removed from cart!');
    }
}
