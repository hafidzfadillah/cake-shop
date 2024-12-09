<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\ShopCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;

        if (!$customer) {
            return redirect()->route('home')->with('error', 'Customer profile not found.');
        }

        $cartItems = ShopCart::where('cust_id', $customer->cust_id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function($item) {
            return $item->item_qty * ($item->product->prod_price_promo ?: $item->product->prod_price);
        });

        return view('checkout.index', compact('cartItems', 'total', 'customer'));
    }

    public function process(Request $request)
    {
        try {
            $request->validate([
                'shipping_address' => 'required|string',
                'payment_method' => 'required|in:transfer,cod'
            ]);

            $customer = Auth::user()->customer;
            Log::info('Customer found:', ['cust_id' => $customer->cust_id]);

            $cartItems = ShopCart::where('cust_id', $customer->cust_id)
                ->with('product')
                ->get();
            Log::info('Cart items:', ['count' => $cartItems->count()]);

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
            }

            $total = $cartItems->sum(function($item) {
                return $item->item_qty * ($item->product->prod_price_promo ?: $item->product->prod_price);
            });
            Log::info('Calculated total:', ['total' => $total]);

            DB::beginTransaction();
            try {
                // Create transaction
                $transaction = Transaction::create([
                    'cust_id' => $customer->cust_id,
                    'payment_method' => $request->payment_method,
                    'rp_total' => $total,
                    'transaction_datetime' => now(),
                    'transaction_status' => 'pending',
                    'ship_address' => $request->shipping_address,
                    'created_at' => now()
                ]);
                Log::info('Transaction created:', ['transaction_id' => $transaction->transaction_id]);

                // Create transaction items
                foreach ($cartItems as $item) {
                    Log::info('Processing cart item:', [
                        'prod_id' => $item->prod_id,
                        'qty' => $item->item_qty,
                        'price' => $item->product->prod_price_promo ?: $item->product->prod_price
                    ]);

                    TransactionItem::create([
                        'transaction_id' => $transaction->transaction_id,
                        'prod_id' => $item->prod_id,
                        'qty' => $item->item_qty,
                        'unit_price' => $item->product->prod_price_promo ?: $item->product->prod_price,
                        'subtotal' => $item->unit_price * $item->qty,
                        'created_at' => now()
                    ]);

                    // Update product stock
                    $item->product->decrement('prod_stock', $item->item_qty);
                    Log::info('Stock updated for product:', [
                        'prod_id' => $item->prod_id,
                        'new_stock' => $item->product->prod_stock
                    ]);
                }

                // Clear cart
                ShopCart::where('cust_id', $customer->cust_id)->delete();
                Log::info('Cart cleared for customer:', ['cust_id' => $customer->cust_id]);

                DB::commit();
                Log::info('Transaction completed successfully');

                return redirect()->route('transactions.show', $transaction->transaction_id)
                               ->with('success', 'Order placed successfully!');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Transaction failed:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->with('error', 'Failed to process order. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('Validation or pre-transaction error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'An error occurred. Please try again.');
        }
    }
}
