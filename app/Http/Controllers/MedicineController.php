<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\MedicineResource;
use App\Http\Resources\MedicineCollection;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;

class MedicineController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Medicine::class, 'medicine');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new MedicineCollection(Medicine::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = app(StoreMedicineRequest::class)->validated();

        DB::transaction(function () use ($validatedData) {
            $category = Category::where('name', $validatedData['category_name'])->first();
            $supplier = Supplier::where('name', $validatedData['supplier_name'])->first();
            
            Medicine::create([
                'brand_name' => $validatedData['brand_name'],
                'generic_name' => $validatedData['generic_name'],
                'dosage' => $validatedData['dosage'],
                'category_id' => $category->id,
                'supplier_id' => $supplier->id,
                'manufacturer' => $validatedData['manufacturer'],
                'batch_number' => $validatedData['batch_number'],
                'expiration_date' => $validatedData['expiration_date'],
                'quantity' => $validatedData['quantity'],
                'purchase_price' => $validatedData['purchase_price'],
                'selling_price' => $validatedData['selling_price'],
                'description' => $validatedData['description'],
            ]);
        });

        return response()->json(['message' => 'Medicine added successfully!'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        return new MedicineResource($medicine);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        Medicine::findOrFail($medicine->id);

        $validatedData = app(UpdateMedicineRequest::class)->validated();

        DB::transaction(function () use ($validatedData, $medicine) {
            $category = Category::where('name', $validatedData['category_name'])->first();
            $supplier = Supplier::where('name', $validatedData['supplier_name'])->first();
            
            $medicine->update([
                'brand_name' => $validatedData['brand_name'],
                'generic_name' => $validatedData['generic_name'],
                'dosage' => $validatedData['dosage'],
                'category_id' => $category->id, 
                'supplier_id' => $supplier->id, 
                'manufacturer' => $validatedData['manufacturer'],
                'batch_number' => $validatedData['batch_number'],
                'expiration_date' => $validatedData['expiration_date'],
                'quantity' => $validatedData['quantity'],
                'purchase_price' => $validatedData['purchase_price'],
                'selling_price' => $validatedData['selling_price'],
                'description' => $validatedData['description'],
            ]);
        });

        return response()->json(['message' => 'Medicine updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        try {
            $medicine->delete();

            return response()->json([
                'message' => 'Medicine deleted successfully',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete the medicine',
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
