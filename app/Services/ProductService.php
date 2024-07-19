<?php

namespace App\Services;

use App\Repositories\ProductRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Services\ImageService;

class ProductService
{
    protected $productRepository;
    protected $categoryRepository;
    protected $imageService;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        ImageService $imageService
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->imageService = $imageService;
    }

    public function createProduct(array $data, array $categoryIds = [])
    {
        if (isset($data['image'])) {
            $data['image'] = $this->imageService->uploadImage($data['image']);
        }

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

    public function updateProduct($id, array $data)
    {
        return $this->productRepository->update($id, $data);

    }
    

    public function deleteProduct($id)
    {
        return $this->productRepository->delete($id);
    }


}