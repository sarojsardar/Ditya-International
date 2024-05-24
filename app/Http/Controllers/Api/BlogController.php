<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\News;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function getBlogList(){

        $bloglist = News::orderBy('created_at', 'desc')->get();

        $bloglist = $this->data =  BlogResource::collection($bloglist);

        return response()->json([
            'data' => $bloglist,
            'message' => 'Blog List'
        ]);
    }

    public function getblogDetails($slug){
        $blog = News::where('slug', '=', $slug)->first();
        if(!$blog){
            $data['status']='error';
            $data['message']='Blog Details Not Found';
            return response()->json($data, 400);
        }else {
            $data = array(
                'title' => $blog->title,
                'slug' => $blog->slug,
                'content' => $blog->content,
                'thumbnail' => $blog->thumbnail != null ? url('storage/uploads/news-images').'/'.$blog->thumbnail : null,
                'created_at' => $blog->created_at->format('F jS, Y'),
            );

            return response()->json([
                'data' => $data,
                'message' => 'Blog Details'
            ]);

        }
    }
}
