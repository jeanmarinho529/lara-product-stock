<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repository\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        try{
            $data = Cache::remember('all-category', now()->addMinute(120), function () {
                return $this->categoryRepository->get(['id','name']);
            });
            
            return response()->json(['success' => true, 'data' => $data], 200);

        } catch(ModelNotFoundException $e) {
            return response()->json('Not Found',404);
        } catch(\Exception $e) {
            info($e);
            return response()->json(['success' => false, 'data' => 'Error when listing categories'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(CategoryRequest $request)
    {
        try{
            $data = $this->categoryRepository->create($request->all());
            if($data) {
                Cache::forget('all-category');
                return response()->json(['success' => true, 'data' => $data], 201);
            }

        } catch(\Exception $e) {
            info($e);
            return response()->json(['success' => false, 'data' => 'Error creating category'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(int $id)
    {
        try{
            $data = $this->categoryRepository->find($id);
            return response()->json(['success' => true, 'data' => $data], 200);

        } catch(ModelNotFoundException $e) {
            return response()->json('Not Found',404);
        } catch(\Exception $e) {
            info($e);
            return response()->json(['success' => false, 'data' => 'Error creating category'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(CategoryRequest $request, int $id)
    {
        try{
            $data = $this->categoryRepository->update($id, $request->all());
            
            if($data) {
                Cache::forget('all-category');
                return response()->json([],204);
            }

        } catch(ModelNotFoundException $e) {
            return response()->json('Not Found',404);
        } catch(\Exception $e) {
            info($e);
            return response()->json(['success' => false, 'data' => 'Error creating category'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(int $id)
    {
        try{
            $data = $this->categoryRepository->delete($id);
            
            if($data) {
                Cache::forget('all-category');
                return response()->json([],204);                
            }
        
        } catch(ModelNotFoundException $e) {
            return response()->json('Not Found',404);
        } catch(\Exception $e) {
            info($e);
            return response()->json(['success' => false, 'data' => 'Error creating category'], 500);
        }
    }
}
