<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $productService)
    {
        $this->categoryService = $productService;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->getCategories($request->all());
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'categories' => 'array',
        ]);

        $product = $this->productService->createProduct($validatedData);
        return response()->json($product, 201);
    }


}
