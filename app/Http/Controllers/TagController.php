<?php

namespace App\Http\Controllers;

use App\Models\Tag;
// use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\FetchRequest;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Requests\DestroyRequest;

class TagController extends BaseController
{

    public function getTags() 
    {
        return Tag::orderBy("created_at", "desc")->get();
    }

    public function index(FetchRequest $request) 
    {
        
        if( $response = $this->validateRequest($request) ) {
            return response()->json($response);
        }

        try {

            $tags = $this->getTags();
            $response = [ 'status' => 200, 'tags' => $tags, 'msg' => 'Fetched tags'];
            return response()->json($response);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(StoreTagRequest $request)
    {
        // Validate
        if ( $response = $this->validateRequest($request) ) {
            return response()->json($response);
        }
        
        try {
            // Check tag name if exists
            $isTagExist = Tag::where('tagName', $request->tagName)
                        // ->where('store_id',$request->store_id) // temp we will be using auth
                        ->first();

            if ( $isTagExist ) {
                $response = ['status' => 409, 'msg' => 'Tag has already been exist.'];
                return response()->json($response);
            }

            $payload = [ 'tagName' => strip_tags($request->tagName) ];
            $tag = new Tag( $payload );
            if ( $tag->save() ) {
                $tags = $this->getTags();
                $response = [ 'status' => 201, 'tags' => $tags, 'msg' => 'Tag has been added successfully!' ];
            }
            else $response = [ 'status' => 500, 'msg' => 'Internal server error' ];

            return response()->json($response);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(UpdateTagRequest $request)
    {

        if ( $response = $this->validateRequest($request) ) {
            return response()->json($response);
        }

        try {
            $id = $request->id;
            $tag = Tag::find($id);

            // Check tag name if exists
            $isTagExist = Tag::where('tagName', $request->tagName)
                        ->where('id', '!=', $id)
                        ->first();

            if ( $isTagExist ) {
                $response = ['status' => 409, 'msg' => 'Tag has already been exist.'];
                return response()->json($response);
            }
    
            // Continue saving
            $tag->tagName   = strip_tags($request->tagName);
            if ( $tag->save() ) {
                $tags = $this->getTags();
                $response = [ 'status' => 201, 'tags' => $tags, 'msg' => 'Tag has been updated successfully!' ];
            }
            else $response = [ 'status' => 500, 'msg' => 'Internal server error' ];
    
            return response()->json($response);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(DestroyRequest $request)
    {

        if( $response = $this->validateRequest($request) ) {
            return response()->json($response);
        } 

        try {
            
            $id = $request->id;
            $tag = Tag::find($id);
            
            if( $tag ) {
                if( $tag->delete() ){
                    $tags = $this->getTags();
                    $response = [ 'status' => 200, 'tags' => $tags, 'msg' => 'Tag has been deleted successfully!'];
                }
            }
            else $response = [ 'status' => 500, 'msg' => 'Internal server error' ];

            return response()->json($response);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
