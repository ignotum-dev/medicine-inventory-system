<?php

namespace App\Http\Controllers;

use App\Events\PurchaseEvent;
use App\Http\Resources\PurchaseResource;
use App\Models\Order;
use App\Models\User;
use App\Models\Medicine;
use App\Models\Purchase;
use App\Mail\LowStockAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function purchase(Request $request, Purchase $purchase)
    {
        $this->authorize('purchase', $purchase);

        // Validate the request for multiple items
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.brand_name' => 'required|exists:brands,name',
            'items.*.generic_name' => 'required|exists:medicines,generic_name',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $purchasedItems = [];
        $totalPurchasePrice = 0;

        DB::beginTransaction();

        try {
            $order = Order::create([
                'order_number' => 'ORD-' . now()->format('YmdHis'),
                'processed_by_id' => auth()->id(),
                'total_amount' => 0,
            ]);

            foreach ($validated['items'] as $item) {
                // Find the medicine by joining with brands table
                $medicine = Medicine::whereHas('brand', function ($query) use ($item) {
                    $query->where('name', $item['brand_name']);
                })->where('generic_name', $item['generic_name'])->first();

                if (!$medicine) {
                    throw new \Exception("Medicine with brand '{$item['brand_name']}' and generic name '{$item['generic_name']}' not found.");
                }

                // Check if sufficient quantity is available
                if ($medicine->quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$medicine->generic_name} ({$medicine->brand->name}). Available: {$medicine->quantity}, Requested: {$item['quantity']}");
                }

                // Calculate the total price for this item
                $itemTotalPrice = $medicine->selling_price * $item['quantity'];
                $totalPurchasePrice += $itemTotalPrice;

                activity()->disableLogging();

                // Deduct the quantity
                $medicine->quantity -= $item['quantity'];
                $medicine->save();

                // Log the purchase for each item
                $medicineLog = Purchase::create([
                    'medicine_id' => $medicine->id,
                    'order_id' => $order->id,
                    'quantity' => $item['quantity'],
                    'stocks_left' => $medicine->quantity,
                    'selling_price' => $medicine->selling_price,
                    'total_price' => $itemTotalPrice
                ]);

                activity()->enableLogging()
                    ->causedBy(auth()->user())
                    ->performedOn($medicine)
                    ->withProperties($medicineLog)
                    ->log('purchased');

                // Check for low stock and send an email alert
                if ($medicine->quantity < 10) {
                    Mail::to('geraldivan26@gmail.com')->send(new LowStockAlert($medicine));
                }

                event(new PurchaseEvent('purchased'));

                // Add to purchased items array
                $purchasedItems[] = [
                    'brand_name' => $medicine->brand->name,
                    'generic_name' => $medicine->generic_name,
                    'quantity' => $item['quantity'],
                    'unit_price' => $medicine->selling_price,
                    'total_price' => $itemTotalPrice,
                    'remaining_quantity' => $medicine->quantity
                ];
            }

            $order->update(['total_amount' => $totalPurchasePrice]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred during the purchase.', 'error' => $e->getMessage()], 500);
        }

        // Return the response with all purchased items
        return response()->json([
            'message' => 'Purchase successful.',
            'order_number' => $order->order_number,
            'purchased_items' => $purchasedItems,
            'total_purchase_price' => $totalPurchasePrice,
            'items_count' => count($purchasedItems)
        ]);
    }
}
