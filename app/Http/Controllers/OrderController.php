<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Order::class, 'order');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Order::count() === 0) {
            return response()->json([
                'data' => [],
                'message' => 'No orders found.'
            ], 200);
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $orderQuery = Order::query();

        // Search by order number
        if ($request->filled('search')) {
            $searchData = $request->input('search');
            $orderQuery->where('order_number', 'like', "%{$searchData}%");
        }

        // Filter by processed_by username
        if ($request->filled('processed_by')) {
            $processedByArray = array_map('trim', explode('|', $request->input('processed_by')));
            $orderQuery->whereHas('user', function ($query) use ($processedByArray) {
                $query->whereIn('username', $processedByArray);
            });
        }

        // Filter by date range or default to today
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $orderQuery->whereBetween('orders.created_at', [
                $request->input('start_date') . ' 00:00:00',
                $request->input('end_date') . ' 23:59:59'
            ]);
        } else {
            $orderQuery->whereDate('orders.created_at', today());
        }

        // Sort by related user's username
        if ($sortBy === 'processed_by_id') {
            $orderQuery->join('users', 'orders.processed_by_id', '=', 'users.id')
                ->select('orders.*')
                ->orderBy('users.username', $sortOrder);
        } else {
            $orderQuery->orderBy("orders.$sortBy", $sortOrder);
        }

        $orders = $orderQuery->paginate(10);

        if ($orders->isEmpty()) {
            return response()->json([
                'message' => 'No orders found.',
                'data' => [],
            ], 200);
        }

        return response()->json([
            'data' => OrderResource::collection($orders),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'results_per_page' => $orders->perPage(),
                'total_results' => $orders->total(),
                'total_page' => $orders->lastPage(),
            ],
        ]);
    }

}
