<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Medicine;
use App\Models\Purchase;
use Illuminate\Http\Request;

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
            ['brand_name',$validated['brand_name']],
            ['generic_name', $validated['generic_name']],
        ])->first();

        if (!$medicine)
            return response()->json(['message' => 'The selected brand name and generic name is not match or are not found.'], 422);

        // Check if sufficient quantity is available
        if ($medicine->quantity < $validated['quantity']) {
            return response()->json([
                'message' => 'Insufficient stock available.',
                'available_quantity' => $medicine->quantity,
            ], 400);
        }

        // Calculate the total price
        $totalPrice = $medicine->selling_price * $validated['quantity'];

        activity()->disableLogging();
        // Deduct the quantity
        $medicine->quantity -= $validated['quantity'];
        $medicine->save();

        $medicineLog = Purchase::create([
            'medicine_id' => $medicine->id,
            'quantity' => $validated['quantity'],
            'stocks_left' => $medicine->quantity,
            'selling_price' =>$medicine->selling_price,
            'total_price' => $totalPrice
        ]);

        // dd(auth()->user());
        activity()->enableLogging()
            ->causedBy(auth()->user())
            ->performedOn($medicine)
            // ->by($user)
            ->withProperties($medicineLog)
            ->log('purchased');

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
