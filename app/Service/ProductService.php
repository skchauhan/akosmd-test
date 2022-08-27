<?php 
namespace App\Service;

use App\Models\{Product, ProductImage, ProductVariation};
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService {

    private $product;
    private $request;
    private $productId;

    
    /**
     * getAllProduct
     *
     * @return void
     */
    public function getAllProduct()
    {
        try {
            return Product::latest()->paginate(20);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * getProduct
     *
     * @param  mixed $request
     * @return void
     */
    public function getOneProduct($productId){
        try {
            return Product::with('variation','productImage')->findOrFail($productId);
        } catch (ModelNotFoundException $th) {
            return [
                'status' => false,
                'message' => __('lang.product_not_found'),
                'code'   => 404
            ];
        }
    }
    
    /**
     * deleteProduct
     *
     * @param  mixed $productId
     * @return void
     */
    public function deleteProduct($productId)
    {
        try {
            $response =  Product::where('id', $productId)->firstOrFail()->delete();
            if($response) {
                return [
                    'status' => true,
                    'message' => __('lang.product_delete'),
                    'code'   => 200
                ];
            }
        } catch (ModelNotFoundException $th) {
            return [
                'status' => false,
                'message' => __('lang.product_not_found'),
                'code'   => 404
            ];
        }
    }
    
    /**
     * storeProduct
     *
     * @param  mixed $request
     * @return void
     */
    public function storeProduct($request)
    {
        try {
            DB::beginTransaction();
            $this->request = $request;
            $this->insertProduct();
            $this->insertProductVariation();
            
            if( isset($this->product->id) && $this->product->id != 0) {
                $response = [
                    'status'      => true, 
                    'data'        => [
                        "product_name" => $this->product->product_name
                    ],
                    'message'     => __('lang.product_added'), 
                    'code'        => 200
                ];
            } else {
                $response = [
                    'status'      => false, 
                    'data'        => '',
                    'message'     => __('lang.added_failed'), 
                    'code'        => 400
                ];
            }
            return $response;
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    
    /**
     * insertProduct
     *
     * @return void
     */
    public function insertProduct() {
        try {
            $arrProduct = $this->request->only(['product_name', 'product_barcode', 'price_based_on']);
            $this->product = Product::create($arrProduct);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    /**
     * insertProductVariation
     *
     * @return void
     */
    public function insertProductVariation()
    {
        try {
            //Create Product Variation
            $variations = $this->request->variations;
            $newProductVariation = [];
            foreach ($variations as $value) {
                $newProductVariation = [
                    'price' => $value['price'],
                    'unit' => $value['unit']
                ];
                $variation = $this->product->variation()->create($newProductVariation);
                
                //Inert product image
                if(!empty($value['images'])) {
                    foreach ($value['images'] as $value) {
                        $variation->productImage()->create([
                            'product_id' => $this->product->id,
                            'product_image' => $value,
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    /**
     * updateProduct
     *
     * @param  mixed $request
     * @return void
     */
    public function updateProduct($request, $productId)
    {   
        try {
            DB::beginTransaction();
            $this->request = $request;
            $this->productId = $productId;
            $this->editProduct();
            
            ProductVariation::where('product_id', $productId)->delete();
            ProductImage::where('product_id', $productId)->delete();
            $this->insertProductVariation();
            
            if( isset($this->product->id) && $this->product->id != 0) {
                $response = [
                    'status'      => true, 
                    'data'        => [
                        "product_name" => $this->product->product_name
                    ],
                    'message'     => __('lang.product_update'), 
                    'code'        => 200
                ];
            } else {
                $response = [
                    'status'      => false, 
                    'data'        => '',
                    'message'     => __('lang.update_failed'), 
                    'code'        => 400
                ];
            }
            return $response;
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    
    /**
     * editProduct
     *
     * @return void
     */
    public function editProduct()
    {
        try {
            $arrProduct = $this->request->only(['product_name', 'product_barcode', 'price_based_on']);
            $productId = Product::where('id', $this->productId)->update($arrProduct);
            $this->product = $this->getOneProduct($productId);            
        } catch (\Throwable $th) {
            throw $th;
        } 
    }    
    
}