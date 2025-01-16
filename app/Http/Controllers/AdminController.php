<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        try {
            Log::info('Fetching admin dashboard statistics...');

            // Get summary statistics
            $totalSales = Transaction::where('transaction_status', 'completed')
                ->sum('rp_total');
            Log::debug('Total sales: ' . $totalSales);

            $pendingOrders = Transaction::where('transaction_status', 'pending')->count();
            Log::debug('Pending orders: ' . $pendingOrders);

            $totalProducts = Product::count();
            Log::debug('Total products: ' . $totalProducts);

            $totalCustomers = Customer::whereHas('user', function($query) {
                $query->where('is_admin', false);
            })->count();
            Log::debug('Total customers: ' . $totalCustomers);

            // Get recent transactions
            $recentTransactions = Transaction::with(['customer', 'transactionItems'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            Log::debug('Recent transactions count: ' . $recentTransactions->count());

            // Get low stock products (less than 10 items)
            $lowStockProducts = Product::where('prod_stock', '<', 10)
                ->orderBy('prod_stock', 'asc')
                ->take(5)
                ->get();
            Log::debug('Low stock products count: ' . $lowStockProducts->count());

            // Get sales data for chart
            $monthlySales = Transaction::where('transaction_status', 'completed')
                ->select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('SUM(rp_total) as total')
                )
                ->groupBy('month')
                ->orderBy('month')
                ->get();
            Log::debug('Monthly sales data points: ' . $monthlySales->count());

            Log::info('All dashboard data fetched successfully');

            $view = view('admin.dashboard', compact(
                'totalSales',
                'pendingOrders',
                'totalProducts',
                'totalCustomers',
                'recentTransactions',
                'lowStockProducts',
                'monthlySales'
            ));

            if (!$view) {
                Log::error('Failed to load admin dashboard view');
                throw new \Exception('Failed to load dashboard view');
            }

            Log::info('Admin dashboard view loaded successfully');
            return $view;

        } catch (\Exception $e) {
            Log::error('Error in admin dashboard: ' . $e->getMessage());
            throw $e;
        }
    }
}
