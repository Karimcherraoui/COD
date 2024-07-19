<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->getProducts($request->all());
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);
    
        $categories = $validatedData['categories'] ?? [];
        unset($validatedData['categories']);
    
        $product = $this->productService->createProduct($validatedData, $categories);
        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = $this->productService->getProduct($id);
        return response()->json($product);
    }
    public function update(Request $request, Product $product)
    {
        // Log request data as an array
        Log::info('Update Request Data:', $request->all());
    
        // Handle other logging
        Log::info('Name:', ['name' => $request->input('name')]);
        Log::info('Description:', ['description' => $request->input('description')]);
        Log::info('Price:', ['price' => $request->input('price')]);
        Log::info('Categories:', ['categories' => $request->input('categories')]);
    
        if ($request->hasFile('image')) {
            Log::info('Image File:', ['image_file' => $request->file('image')->getClientOriginalName()]);
        }
    
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'nullable|array',
        ]);
    
        // Handle the image upload if present
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $imagePath;
        }
    
        $updatedProduct = $this->productService->updateProduct($product->id,$validatedData);

        return response()->json($updatedProduct, 200);
    }
    
    
    

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return response()->json(null, 204);
    }




}