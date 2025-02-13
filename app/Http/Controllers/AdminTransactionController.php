<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['customer', 'transactionItems']);

        if ($request->has('search')) {
            $search = $request->get('search');
            $dtSearch = $request->get('date');
            $stat = $request->get('status');

            if($search) {
                $query->whereHas('customer', function($q) use ($search) {
                    $q->whereRaw('LOWER(cust_name) LIKE ?', ["%{$search}%"])
                      ->orWhereRaw('LOWER(cust_email) LIKE ?', ["%{$search}%"])
                      ->orWhereRaw('cust_nohp LIKE ?', ["%{$search}%"]);
                })
                ->orWhereRaw('LOWER(ship_address) LIKE ?', ["%{$search}%"])
                ->orWhere('payment_method','LIKE', "%{$search}%");
            }

            if($dtSearch) {
                $query->where('transaction_datetime','LIKE',"%{$dtSearch}%");
            }

            if($stat) {
                $query->where('transaction_status','LIKE',"%{$stat}%");
            }
        }

        // $transactions = Transaction::with('customer')->get();
        $transactions = $query->orderBy('transaction_datetime', 'desc')->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with('customer')->findOrFail($id);
        $transactionDetails = TransactionItem::with('product')
            ->where('transaction_id', $id)
            ->get();
        return view('admin.transactions.show', compact('transaction', 'transactionDetails'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'transaction_status' => 'required|in:pending,completed,cancelled',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->transaction_status = $request->transaction_status;
        $transaction->save();

        return redirect()->route('admin.transactions')->with('success', 'Transaction status updated successfully.');
    }

    public function filter(Request $request)
    {
        $transactions = Transaction::filter($request->all())->get();
        $search = $request->search ?? null;
        $date = $request->date ?? null;
        $status = $request->status ?? null;
        return view('admin.transactions.index', compact('transactions', 'search', 'date', 'status'));
    }
}
