<?php

namespace App\Console\Commands;

use App\Services\ProductService;
use Illuminate\Console\Command;

class DeleteProduct extends Command
{
    protected $signature = 'product:delete {id}';
    protected $description = 'Delete a product';

    protected $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    public function handle()
    {
        $id = $this->argument('id');

        if ($this->productService->deleteProduct($id)) {
            $this->info("Product with ID {$id} deleted successfully");
        } else {
            $this->error("Failed to delete product with ID {$id}");
        }
    }
}