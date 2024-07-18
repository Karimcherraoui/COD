<?php

namespace App\Services;

use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function createProduct(array $data, array $categoryIds = [])
    {
        $product = $this->productRepository->create($data);

        if (!empty($categoryIds)) {
            $categories = $this->categoryRepository->findMany($categoryIds);
            $product->categories()->attach($categories);
        }

        return $product;
    }

    public function getProducts()
    {
        return $this->productRepository->all();
    }

    public function getProduct($id)
    {
        return $this->productRepository->find($id);
    }

    public function updateProduct(array $data, $id)
    {
        return $this->productRepository->update($data, $id);
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->delete($id);
    }


}