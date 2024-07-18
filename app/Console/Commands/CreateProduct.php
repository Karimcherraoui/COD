<?php

namespace App\Console\Commands;

use App\Services\ProductService;
use Illuminate\Console\Command;

class CreateProduct extends Command
{
    protected $signature = 'product:create {name} {description} {price} {--categories=*} {--image=}';
    protected $description = 'Create a new product';

    protected $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    public function handle()
    {
        $name = $this->argument('name');
        $description = $this->argument('description');
        $price = $this->argument('price');
        $categories = $this->option('categories');
        $imagePath = $this->option('image');

        $data = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
        ];

        if ($imagePath) {
            if (file_exists($imagePath)) {
                $fileName = basename($imagePath);
                $storedPath = 'products/' . uniqid() . '_' . $fileName;
                
                if (copy($imagePath, storage_path('app/public/' . $storedPath))) {
                    $data['image'] = $storedPath;
                } else {
                    $this->error("Failed to copy image file.");
                    return;
                }
            } else {
                $this->error("Image file not found: $imagePath");
                return;
            }
        }

        $product = $this->productService->createProduct($data, $categories);

        $this->info("Product '{$product->name}' created successfully with ID: {$product->id}");
        if (!empty($categories)) {
            $this->info("Assigned categories: " . implode(', ', $categories));
        }
        if (isset($data['image'])) {
            $this->info("Image stored at: {$data['image']}");
        }
    }
}