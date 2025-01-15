<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    // Menampilkan daftar pelanggan
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customers.index', compact('customers'));
    }

    // Menampilkan form edit pelanggan
    public function edit($cust_id)
    {
        $customer = Customer::findOrFail($cust_id);
        return view('admin.customers.edit', compact('customer'));
    }

    // Memperbarui data pelanggan
    public function update(Request $request, $cust_id)
    {
        $request->validate([
            'cust_name' => 'required|string|max:255',
            'cust_email' => 'required|email|max:255',
            'cust_nohp' => 'required|string|max:15',
        ]);

        $customer = Customer::findOrFail($cust_id);
        $customer->update($request->all());

        return redirect()->route('admin.customers')
            ->with('success', 'Customer updated successfully.');
    }

    // Menghapus pelanggan
    public function destroy($cust_id)
    {
        $customer = Customer::findOrFail($cust_id);
        $customer->delete();
        return redirect()->route('admin.customers')->with('success', 'Customer deleted successfully.');
    }
}
