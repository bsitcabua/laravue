<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\FetchRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\DestroyRequest;

class CategoryController extends BaseController
{
    public function getCategories()
    {
        return Category::orderBy("created_at", "desc")->get();
    }

    public function index(FetchRequest $request) 
    {
        
        if( $response = $this->validateRequest($request) ) {
            return response()->json($response);
        }

        try {

            $categories = $this->getCategories();
            $response = [ 'status' => 200, 'categories' => $categories, 'msg' => 'Fetched categories'];
            return response()->json($response);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(StoreCategoryRequest $request) 
    {

        // Validate
        if ( $response = $this->validateRequest($request) ) {
            return response()->json($response);
        }
        
        try {
            // Check category name if exists
            $isCategoryExist = Category::where('categoryName', $request->categoryName)
                        // ->where('store_id',$request->store_id) // temp we will be using auth
                        ->first();

            if ( $isCategoryExist ) {
                $response = ['status' => 409, 'msg' => 'Category has already been exist.'];
                return response()->json($response);
            }

            $payload = [ 'categoryName' => strip_tags($request->categoryName) ];
            $category = new Category( $payload );
            if ( $category->save() ) {
                $categories = $this->getCategories();
                $response = [ 'status' => 201, 'categories' => $categories, 'msg' => 'Category has been added successfully!' ];
            }
            else $response = [ 'status' => 500, 'msg' => 'Internal server error' ];

            return response()->json($response);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function upload(Request $request)
    {

        try {
            
            $fileName = time().'.'.$request->file->extension();
            $request->file->move(public_path('uploads'), $fileName);
            return $fileName;

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
