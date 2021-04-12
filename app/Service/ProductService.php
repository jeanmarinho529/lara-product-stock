<?php

namespace App\Service;

use App\Http\Resources\ListProductResource;
use App\Jobs\SendEmailProductMinimumJob;
use App\Repository\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService extends ServiceProvider
{
    private $productInterface;

    public function __construct(ProductRepositoryInterface $productInterface)
    {
        $this->productInterface = $productInterface;
    }


    public function index()
    {
        try{
            $data = $this->productInterface->listProducts();
            $data = ListProductResource::collection($data);
            
            return ['success' => true, 'data' => $data, 'code' => 200];

        } catch(ModelNotFoundException $e) {
            return ['success' => false, 'message' => 'Not Found.', 'code' => 404];
        } catch(\Exception $e) {
            info($e);
            return response()->json(['success' => false, 'data' => 'Error listing all products'], 500);
        }
    }

    public function show(string $slug)
    {
        try{
            $data = $this->productInterface->findProduct($slug);
            
            return ['success' => true, 'data' => $data, 'code' => 200];

        } catch(ModelNotFoundException $e) {
            return ['success' => false, 'message' => 'Not Found.', 'code' => 404];
        } catch(\Exception $e) {
            info($e);
            return response()->json(['success' => false, 'data' => 'Error listing all products'], 500);
        }
    }

    public function store(array $params)
    {
        try{
            $data = $this->productInterface->createProduct($params);
            
            return ['success' => true, 'data' => $data, 'code' => 201];

        } catch(ModelNotFoundException $e) {
            return ['success' => false, 'message' => 'Not Found.', 'code' => 404];
        } catch(\Exception $e) {
            info($e);
            return response()->json(['success' => false, 'data' => 'Error listing all products'], 500);
        }
    }

    public function update(string $slug, array $params)
    {
        try{
            $product = $this->productInterface->findProduct($slug);

            if (Gate::allows('verify-user-product',$product)) {
                $data = $product->update($params);
                return ['success' => true, 'data' => $data, 'code' => 204];
            }

            return ['success' => false, 'message' => 'Unauthorized user.', 'code' => 403];

        } catch(ModelNotFoundException $e) {
            return ['success' => false, 'message' => 'Not Found.', 'code' => 404];
        } catch(\Exception $e) {
            info($e);
            return ['success' => false, 'message' => 'Error updating product.', 'code' => 500];
        }
    }

    public function delete(string $slug)
    {
        try{
            $product = $this->productInterface->findProduct($slug, ['id','user_id']);

            if (Gate::allows('verify-user-product',$product)) { 
                $data = $product->delete();
                return ['success' => true, 'data' => $data, 'code' => 204];
            }

            return ['success' => false, 'message' => 'Unauthorized user.', 'code' => 403];

        } catch(ModelNotFoundException $e) {
            return ['success' => false, 'message' => 'Not Found.', 'code' => 404];
        } catch(\Exception $e) {
            info($e);
            return ['success' => false, 'message' => 'Error when deleting product.', 'code' => 500];
        }
    }

    public function movement(string $slug, int $quantity)
    {
        try{
            $product = $this->productInterface->findProduct($slug, ['id','user_id','current_quantity','minimum_quantity']);

            if (Gate::allows('verify-user-product',$product)) { 
                $quantity = $product->current_quantity + $quantity;

                if  ($quantity >= 0) {
                    if ($quantity <= $product->minimum_quantity and !($product->current_quantity <= $product->minimum_quantity)) {
                        SendEmailProductMinimumJob::dispatch($product, $product->user)->delay(now()->addSeconds(10));
                    }

                    $data = $this->productInterface->updateProduct($slug, ['current_quantity' => $quantity]);
                    return ['success' => true, 'data' => $data, 'code' => 204];
                }

                return ['success' => false, 'message' => 'We do not have this quantity available for withdrawal. Available quantity: ' . $product->current_quantity, 'code' => 409];
            }

            return ['success' => false, 'message' => 'Unauthorized user.', 'code' => 403];

        } catch(ModelNotFoundException $e) {
            return ['success' => false, 'message' => 'Not Found.', 'code' => 404];
        } catch(\Exception $e) {
            info($e);
            return ['success' => false, 'message' => 'Error updating product.', 'code' => 500];
        }
    }
}
