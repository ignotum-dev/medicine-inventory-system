<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Mail\LowStockAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
    public function index(Medicine $medicine)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($medicine)
            ->log('index');

        return new MedicineCollection(Medicine::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = app(StoreMedicineRequest::class)->validated();

        DB::transaction(function () use ($validatedData) {
            $brand = Brand::where('name', $validatedData['brand_name'])->first();
            $category = Category::where('name', $validatedData['category_name'])->first();
            $supplier = Supplier::where('name', $validatedData['supplier_name'])->first();

            Medicine::create([
                'generic_name' => $validatedData['generic_name'],
                'dosage' => $validatedData['dosage'],
                'brand_id' => $brand->id,
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
        activity()
            ->causedBy(auth()->user())
            ->performedOn($medicine)
            ->withProperties(new MedicineResource($medicine))
            ->log('show');

        return new MedicineResource($medicine);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        Medicine::findOrFail($medicine->id);

        $validatedData = app(UpdateMedicineRequest::class)->validated();

        if ($validatedData['quantity'] < 10) {
            // Send the email
            Mail::to('geraldivan26@gmail.com')->send(new LowStockAlert($medicine));
        }

        DB::transaction(function () use ($validatedData, $medicine) {
            $brand = Category::where('name', $validatedData['brand_name'])->first();
            $category = Category::where('name', $validatedData['category_name'])->first();
            $supplier = Supplier::where('name', $validatedData['supplier_name'])->first();

            $medicine->update([
                'brand_name' => $brand->id,
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

    public function search(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $sortBy = $request->input('sort_by', 'generic_name');
        $sortOrder = $request->input('sort_order', 'asc');
        $expirationDateOperator = $request->input('expiration_date_operator', '>=');

        // Initialize the base query for medicines

        $medicinesQuery = Medicine::query();

        // Apply conditional logic for searching
        if ($request->has('search')) {
            $search = $request->input('search');
            $date = date('Y-m-d', strtotime($search)); // Convert search to date if possible

            $medicinesQuery->where(function ($query) use ($search, $date) {
                $query
                    ->orWhere('generic_name', 'like', "%{$search}%")
                    ->orWhere('manufacturer', 'like', "%{$search}%")
                    ->orWhere('batch_number', 'like', "%{$search}%")
                    ->orWhereDate('expiration_date', $date)
                    ->orWhere('description', 'like', "%{$search}%");
            });

            // // Optionally, search in related models
            // // Check if search contains multiple categories (comma-separated)
            // if (strpos($search, ',') !== false) {
            //     $categories = array_map('trim', explode(',', $search));
            //     $medicinesQuery->orWhereHas('category', function ($query) use ($categories) {
            //         $query->whereIn('name', $categories);
            //     });
            // } else {
            //     $medicinesQuery->orWhereHas('category', function ($query) use ($search) {
            //         $query->where('name', 'like', "%{$search}%");
            //     });
            // }

            // $medicinesQuery->orWhereHas('supplier', function ($query) use ($search) {
            //     $query->where('name', 'like', "%{$search}%");
            // });
        }

        // Filter by expiration date if provided
        if ($request->has('expiration_date')) {
            $expirationFilter = $request->input('expiration_date');
            $expirationDate = date('Y-m-d', strtotime($expirationFilter));
            $medicinesQuery->whereDate('expiration_date', $expirationDateOperator, $expirationDate);
        }

        // Filter by multiple categories if provided (comma-separated)
        if ($request->has('categories')) {
            $categoriesFilter = $request->input('categories');
            $categoriesArray = array_map('trim', explode(',', $categoriesFilter));
            $medicinesQuery->whereHas('category', function ($query) use ($categoriesArray) {
                $query->whereIn('name', $categoriesArray);
            });
        }

        // Filter by multiple categories if provided (comma-separated)
        if ($request->has('brands')) {
            $brandsFilter = $request->input('brands');
            $brandsArray = array_map('trim', explode(',', $brandsFilter));
            $medicinesQuery->whereHas('brand', function ($query) use ($brandsArray) {
                $query->whereIn('name', $brandsArray);
            });
        }

        // Filter by supplier if provided
        if ($request->has('supplier')) {
            $supplierFilter = $request->input('supplier');
            $medicinesQuery->whereHas('supplier', function ($query) use ($supplierFilter) {
                $query->where('name', 'like', "%{$supplierFilter}%");
            });
        }

        // Order and paginate the results
        $medicinesResult = $medicinesQuery
            ->orderBy($sortBy, $sortOrder)
            ->paginate($per_page);

        // Use MedicineCollection for formatting if required
        $medicinesResult = new MedicineCollection($medicinesResult);

        return response()->json([
            'data' => $medicinesResult, // Formatted data
            'pagination' => [
                'current_page' => $medicinesResult->currentPage(),
                'results_per_page' => $medicinesResult->perPage(),
                'total_results' => $medicinesResult->total(),
                'total_page' => $medicinesResult->lastPage(),
            ],
        ]);
    }

    public function uploadImage(Request $request, Medicine $medicine)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $medicine->brand_name . '_' . $medicine->generic_name . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/medicine_images', $imageName);

            $imageUrl = asset('storage/medicine_images/' . $imageName);

            Medicine::where('id', $medicine->id)->update(['image' => $imageUrl]);

            return response()->json([
                'message' => 'Image uploaded successfully!',
                'image_url' => $imageUrl,
            ], 200);
        }

        return response()->json([
            'message' => 'No image uploaded.',
        ], 400);
    }
}
