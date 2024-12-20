<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategory;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $repository;

    public function __construct(Category $model)
    {
        $this->repository = $model;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->repository->get();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateCategory $request)
    {
        $category = $this->repository->create($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $url)
    {
        try {
            $category = $this->repository->where('url', $url)->firstOrFail();
            return new CategoryResource($category);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateCategory $request, string $url)
    {
        try {
            $category = $this->repository->where('url', $url)->firstOrFail();
            $category->update($request->validated());
            return response()->json(['message' => 'categoria atualizada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $url)
    {
        try {
            $category = $this->repository->where('url', $url)->firstOrFail();
            $category->delete();
            return response()->json([], 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'não foi encontrada nenhuma categoria com a url passada'], 404);
        }

    }
}
