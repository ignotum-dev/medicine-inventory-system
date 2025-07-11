<?php

namespace App\Http\Controllers;

use App\Events\BrandEvent;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Brand::class, 'brand');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BrandResource::collection(Brand::all());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = app(StoreBrandRequest::class)->validated();

        DB::transaction(function () use ($validatedData) {
            Brand::create([
                'name' => $validatedData['name'],
            ]);
            event(new BrandEvent('stored'));
        });

        return response()->json(['message' => 'Brand added successfully!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        Brand::findOrFail($brand->id);

        $validatedData = app(UpdateBrandRequest::class)->validated();

        DB::transaction(function () use ($validatedData, $brand) {         
            $brand->update([
                'name' => $validatedData['name'],
            ]);

            event(new BrandEvent('updated'));
        });

        return response()->json(['message' => 'Brand updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
            event(new BrandEvent('deleted'));
            
            return response()->json([
                'message' => 'Brand deleted successfully',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete the brand',
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
