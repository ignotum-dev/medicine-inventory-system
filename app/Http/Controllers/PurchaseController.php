<?php

namespace App\Http\Controllers;

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

        // Validate the request
        $validated = $request->validate([
            'brand_name' => 'required|exists:medicines,brand_name',
            'generic_name' => 'required|exists:medicines,generic_name',
            'quantity' => 'required|integer|min:1',
        ]);

        $medicine = Medicine::where([
            ['brand_name', $validated['brand_name']],
            ['generic_name', $validated['generic_name']],
        ])->first();

        if (!$medicine) {
            return response()->json(['message' => 'The selected brand name and generic name do not match or are not found.'], 422);
        }

        // Check if sufficient quantity is available
        if ($medicine->quantity < $validated['quantity']) {
            return response()->json([
                'message' => 'Insufficient stock available.',
                'available_quantity' => $medicine->quantity,
            ], 400);
        }

        DB::beginTransaction(); // Start the transaction

        try {
            // Calculate the total price
            $totalPrice = $medicine->selling_price * $validated['quantity'];

            activity()->disableLogging();

            // Deduct the quantity
            $medicine->quantity -= $validated['quantity'];
            $medicine->save();

            // Log the purchase
            $medicineLog = Purchase::create([
                'medicine_id' => $medicine->id,
                'quantity' => $validated['quantity'],
                'stocks_left' => $medicine->quantity,
                'selling_price' => $medicine->selling_price,
                'total_price' => $totalPrice
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

            DB::commit(); // Commit the transaction
        } catch (\Exception $e) {
            DB::rollBack(); // Roll back the transaction on error
            return response()->json(['message' => 'An error occurred during the purchase.', 'error' => $e->getMessage()], 500);
        }

        // Return the computed total price
        return response()->json([
            'message' => 'Purchase successful.',
            'medicine' => [
                'brand_name' => $medicine->brand_name,
                'generic_name' => $medicine->generic_name
            ],
            'purchased_quantity' => $validated['quantity'],
            'total_price' => $totalPrice,
            'remaining_quantity' => $medicine->quantity
        ]);
    }
}
