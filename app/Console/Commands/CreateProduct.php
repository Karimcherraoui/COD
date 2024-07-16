<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductService;

class CreateProduct extends Command
{
    protected $signature = 'product:create {name} {description} {price}';
    protected $description = 'Create a new product';

    protected $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    public function handle()
    {
        $data = [
            'name' => $this->argument('name'),
            'description' => $this->argument('description'),
            'price' => $this->argument('price'),
        ];

        $product = $this->productService->createProduct($data);

        $this->info("Product created successfully with ID: {$product->id}");
    }
}