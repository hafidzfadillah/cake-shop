<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;

        if (!$customer) {
            return redirect()->route('home')->with('error', 'Customer profile not found.');
        }

        $transactions = Transaction::where('cust_id', $customer->cust_id)
            ->with('transactionItems.product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with(['transactionItems.product', 'customer'])
            ->where('transaction_id', $id)
            ->firstOrFail();

        // Check if the transaction belongs to the authenticated user
        if ($transaction->cust_id !== Auth::user()->customer->cust_id) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        return view('transactions.show', compact('transaction'));
    }
}
