<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\SupplierCollection;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Supplier::class, 'supplier');
        $this->middleware('permission:view supplier', ['only' => ['index']]);
        $this->middleware('permission:create supplier', ['only' => ['store']]);
        $this->middleware('permission:update supplier', ['only' => ['update']]);
        $this->middleware('permission:delete supplier', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new SupplierCollection(Supplier::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = app(StoreSupplierRequest::class)->validated();

        DB::transaction(function () use ($validatedData) {
            Supplier::create([
                'name' => $validatedData['name'],
                'contact_number' => $validatedData['contact_number'],
                'address' => $validatedData['address'],
                'email' => $validatedData['email'],
            ]);
        });

        return response()->json(['message' => 'Supplier added successfully!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return new SupplierResource($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        Supplier::findOrFail($supplier->id);

        $validatedData = app(UpdateSupplierRequest::class)->validated();

        DB::transaction(function () use ($validatedData, $supplier) {         
            $supplier->update([
                'name' => $validatedData['name'],
                'contact_number' => $validatedData['contact_number'],
                'address' => $validatedData['address'],
                'email' => $validatedData['email'],
            ]);
        });

        return response()->json(['message' => 'Supplier updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();

            return response()->json([
                'message' => 'Supplier removed successfully',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to remove the supplier',
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
