<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Product\UploadImageRequest;
use App\Services\Product\UploadImageService;
use Illuminate\Validation\ValidationException;

class UploadImageController extends ApiController
{
    /**
     * Handle the incoming request.
     *
     * @param UploadImageRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UploadImageRequest $request)
    {
        try {
            $imageData = UploadImageService::importFile($request->validated());
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        }

        return $this->respond($imageData);
    }
}
