<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\ProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProductController extends ApiController
{
    /**
     * A constructor for services is used in this controller.
     *
     * @param ProductService $productService Instance class.
     */
    public function __construct(protected ProductService $productService)
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorizeViewFor('products');

        try {
            $products = $this->productService
                ->products()
                ->paginate($this->getLimitPerPage());
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $this->authorizeEditFor('products');

        try {
            $product = $this->productService
                ->createProduct($request->validated());
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->respondInvalidQuery();
        }

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorizeViewFor('products');

        try {
            $product = $this->productService->getProductById($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest  $request
     * @param int  $productId
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $productId)
    {
        $this->authorizeEditFor('products');

        try {
            $product = $this->productService
                ->updateById($productId, array_filter($request->validated()));
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->respondInvalidQuery();
        }

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $productId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId)
    {
        $this->authorizeEditFor('products');

        try {
            $this->productService->deleteById($productId);
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->respondInvalidQuery();
        }

        return $this->respondObjectDeleted($productId);
    }
}
