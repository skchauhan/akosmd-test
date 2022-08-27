<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Service\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductValidator;
use App\Http\Resources\ProductResource;
use App\Http\Requests\UpdateProductValidator;

class ProductController extends BaseController
{
    public $productService;

    public function __construct(
        ProductService $productService
    )
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->productService->getAllProduct();
        $response = ProductResource::collection($response);

        $this->data = $response ?? [];
        $this->message = 'All Products';
        return $this->sendResponse();
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductValidator $request)
    {
        $response = $this->productService->storeProduct($request);
        if(isset($response['status']) && $response['status']) {
            $this->message = $response['message'] ?? [];
            $this->data = $response['data'] ?? [];
            $this->code = $response['code'] ?? 200;
            return $this->sendResponse();
        } else {
            $this->message = $response['message'] ?? [];
            $this->code = $response['code'] ?? 400;
            return $this->sendError();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($productId)
    {
        if(!empty($productId)) {
            $response = $this->productService->getOneProduct($productId);
            if($response['status']===false) {
                $this->message = $response['message'] ?? '';
                goto notfound;
            }
            $response = new ProductResource($response);
            $this->data = $response ?? [];
            return $this->sendResponse();
        } else {
            notfound:
            return $this->sendError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductValidator $request, Product $product)
    {
        $response = $this->productService->updateProduct($request, $product->id);
        if(isset($response['status']) && $response['status']) {
            $this->message = $response['message'] ?? [];
            $this->data = $response['data'] ?? [];
            $this->code = $response['code'] ?? 200;
            return $this->sendResponse();
        } else {
            $this->message = $response['message'] ?? [];
            $this->code = $response['code'] ?? 400;
            return $this->sendError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId)
    {
        $response = $this->productService->deleteProduct($productId);
        if( isset($response['status']) && $response['status']) {
            $this->message = $response['message'] ?? '';
            $this->data = $response['data'] ?? '';
            $this->code = $response['code'] ?? 200;
            return $this->sendResponse();
        } else {
            $this->message = $response['message'] ?? '';
            $this->data = $response['data'] ?? '';
            $this->code = $response['code'] ?? 404;
            return $this->sendError();
        }
    }
}
