<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //
    public function index()
    {
        //get data from table post
        $posts = Post::latest()->get();

        //make JSON response
        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data' => $posts
        ], 200);
    }

    public function show($id)
    {
        // find post by id
        $post = Post::findOrFail($id);

        //make json response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data' => $post
        ]);
    }

    public function store(Request $req)
    {
        //set validation
        $validator = Validator::make($req->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to databases
        $post = Post::create([
            'title' => $req->title,
            'content' => $req->content
        ]);

        //success save to database
        if($post){
            return response()->json([
                'success' => true,
                'message' => 'Post Created'
            ]);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Failed to Save Post'
        ], 409);
    }

    public function update(Request $req, Post $post)
    {
        //set validation
        $validator = Validator::make($req->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        //response error validator
        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by id
        $post = Post::findOrFail($post->id);

        if($post) {
            //update post
            $post->update([
                'title' => $req->title,
                'content' => $req->content
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data' => $post
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Data Post Not Found!'
        ], 404);
    }

    public function destroy($id)
    {
        //find post by id
        $post = Post::findOrFail($id);

        if($post) {
            //delete post
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post Deleted'
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found'
        ], 404);
    }
}
