<?php

namespace App\Services;

use App\Repositories\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(array $data)
    {

        return $this->productRepository->create($data);
    }

    public function getProducts()
    {
        return $this->productRepository->all();
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->delete($id);
    }


}