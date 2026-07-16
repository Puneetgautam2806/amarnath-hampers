<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        
        $query = Order::query()->orderBy('id', 'desc');
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $orders = $query->get();
        
        // Count counts for badge displays
        $counts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('backoffice.orders.index', compact('orders', 'counts', 'status'));
    }

    /**
     * Display the specified order detail.
     */
    public function show(Order $order)
    {
        $order->load('items.product');
        return view('backoffice.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('orders.show', $order->id)->with('success', 'Order status updated successfully!');
    }
}
