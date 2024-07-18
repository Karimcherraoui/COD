<?php

namespace App\Console\Commands;

use App\Services\CategoryService;
use Illuminate\Console\Command;

class DeleteCategory extends Command
{
    protected $signature = 'category:delete {id}';
    protected $description = 'Delete a category';

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();
        $this->categoryService = $categoryService;
    }

    public function handle()
    {
        $id = $this->argument('id');

        if ($this->categoryService->deleteCategory($id)) {
            $this->info("Category with ID {$id} deleted successfully");
        } else {
            $this->error("Failed to delete category with ID {$id}");
        }
    }
}