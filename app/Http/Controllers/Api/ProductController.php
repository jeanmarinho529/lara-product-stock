<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\{MovementRequest, ProductRequest};
use App\Service\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;   
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $response = $this->productService->index();
        if ($response['code'] === 200)
            return response()->json(['success' => $response['success'], 'data' => $response['data']], $response['code']);

        return response()->json(['success' => $response['success'], 'data' => $response['message']], $response['code']);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(ProductRequest $request)
    {
        $response = $this->productService->store($request->all());

        if ($response['code'] === 201)
            return response()->json(['success' => $response['success'], 'data' => $response['data']], $response['code']);

        return response()->json(['success' => $response['success'], 'data' => $response['message']], $response['code']);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(string $slug)
    {
        $response = $this->productService->show($slug);

        if ($response['code'] === 200)
            return response()->json(['success' => $response['success'], 'data' => $response['data']], $response['code']);
        
        return response()->json(['success' => $response['success'], 'data' => $response['message']], $response['code']);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(ProductRequest $request, string $slug)
    {
        $response = $this->productService->update($slug, $request->all());

        if ($response['code'] === 204)
            return response()->json([], $response['code']);
        
        return response()->json(['success' => $response['success'], 'data' => $response['message']], $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(string $slug)
    {
        $response = $this->productService->delete($slug);

        if ($response['code'] === 204)
            return response()->json([], $response['code']);
        
        return response()->json(['success' => $response['success'], 'data' => $response['message']], $response['code']);
    }

    /**
     * Movement of the quantity of products.
     *
     */
    public function movement(MovementRequest $params,string $slug)
    {
        $response = $this->productService->movement($slug, $params->quantity);

        if ($response['code'] === 204)
            return response()->json([], $response['code']);
        
        return response()->json(['success' => $response['success'], 'data' => $response['message']], $response['code']);
    }
}
