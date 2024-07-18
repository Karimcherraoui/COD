<?php

namespace App\Services;

use App\Repositories\CategoryRepositoryInterface;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function createCategory(array $data)
    {

        return $this->categoryRepository->create($data);
    }

    public function getCategories()
    {
        return $this->categoryRepository->all();
    }

    public function getCategory($id)
    {
        return $this->categoryRepository->find($id);
    }

    public function updateCategory(array $data, $id)
    {
        return $this->categoryRepository->update($data, $id);
    }

    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }


}