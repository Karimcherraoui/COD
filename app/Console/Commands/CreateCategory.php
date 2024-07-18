<?php

namespace App\Console\Commands;

use App\Services\CategoryService;
use Illuminate\Console\Command;

class CreateCategory extends Command
{
    protected $signature = 'category:create {name} {parent_id?}';
    protected $description = 'Create a new category';

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();
        $this->categoryService = $categoryService;
    }

    public function handle()
    {
        $name = $this->argument('name');
        $parentId = $this->argument('parent_id');

        $category = $this->categoryService->createCategory([
            'name' => $name,
            'parent_id' => $parentId,
        ]);

        $this->info("Category '{$category->name}' created successfully with ID: {$category->id}");
    }
}