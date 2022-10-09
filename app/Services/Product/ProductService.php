<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Services\AbstractBaseService;

class ProductService extends AbstractBaseService
{
    /**
     * Return the latest products.
     *
     * @return Product
     */
    public function products()
    {
        return Product::query()->latest();
    }

    /**
     * This function creates a new product in the database
     *
     * @param array $dataProduct An array of data to be inserted into the database.
     *
     * @return Product product is being returned.
     */
    public function createProduct($dataProduct)
    {
        return Product::create($dataProduct);
    }

    /**
     * Get a product by its ID.
     *
     * @param int $id The id of the product you want to get.
     *
     * @return Product
     */
    public function getProductById($id)
    {
        return Product::query()
            ->whereId($id)
            ->firstOrFail();
    }

    /**
     * Update a product by its ID.
     *
     * @param int   $productId The id of the product you want to update.
     * @param array $data      The data to be updated.
     *
     * @return Product product that was updated.
     */
    public function updateById($productId, $data)
    {
        $product = $this->getProductById($productId);
        $product->update($data);

        return $product;
    }

    /**
     * It deletes a product from the database
     *
     * @param int $productId The id of the product you want to delete.
     *
     * @return bool.
     */
    public function deleteById($productId)
    {
        $product = $this->getProductById($productId);

        $product->delete();

        return true;
    }
}
