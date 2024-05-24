<?php

namespace App\Http\Controllers\Backend;

use App\Models\News;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{

    public function index(Request $request){

        if($request->ajax()){
            $news = News::orderBy('created_at', 'desc')->get();
            return DataTables::of($news)
            ->addIndexColumn()
            ->addColumn('content', function($row){
                return Str::limit($row->content, 50, $end='...');
            })
            ->addColumn('thumbnail', function($row){
                // Ensure the URL is correctly pointing to the `public/storage` symlink
                $url = url('/storage/uploads/news-images/'.$row->thumbnail);
                return "<img src='{$url}' alt='News thumbnail' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })
            ->addColumn('action', function($row){
                $editUrl = route('website.news.edit', $row->slug);
                $btns = "";
                if(auth('web')->user()->hasPermissionTo('webContent-delete')){
                    $btns = $btns.' '."<button class='btn btn-sm btn-danger' onclick='deleteNews({$row->id})'><i class='las la-trash'></i> Delete</button>";
                }
                if(auth('web')->user()->hasPermissionTo('webContent-update')){
                    $btns = $btns.' '."<a href='{$editUrl}'><button class='btn btn-sm btn-primary'><i class='las la-edit'></i> Edit</button></a>";
                }
                return $btns;
            })
            ->rawColumns(['DT_RowIndex', 'thumbnail', 'content', 'action'])
            ->make(true);
        }
        return view('backend.website.news.index');
    }

    public function create(){
        $news = new News();
        return view('backend.website.news.form', compact('news'));
    }
    public function edit($slug){
        $news = News::where('slug', $slug)->first();
        return view('backend.website.news.form', compact('news'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|unique:news,title',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,gif|max:4048',
            'description' => 'required'
        ]);

        DB::beginTransaction();
        try{

            $file = $request->file('thumbnail');
            $originalName = $file->getClientOriginalName();
            $originalName = pathinfo($originalName, PATHINFO_FILENAME);
            $filename = (new ImageUploadHelper())->uploadImage($file, '/public/uploads/news-images', $originalName);

            News::create([
                'title' => $request->title,
                'thumbnail' => $filename,
                'content' => $request->description
            ]);

            DB::commit();
            return redirect()->route('website.news.index')->with('success', 'News added successfully');


        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('website.news.index')->with('error', 'Something went wrong');
        }

    }
    public function update(Request $request, $newsId){
        $request->validate([
            'title' => 'required|unique:news,title,'.$newsId.',id',
            'thumbnail' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,gif|max:4048',
            'description' => 'required'
        ]);

        $news = News::find($newsId);

        DB::beginTransaction();
        try{

            $filename = $news->thumbnail;

            if($request->hasFile('thumbnail')){
                $file = $request->file('thumbnail');
                $originalName = $file->getClientOriginalName();
                $originalName = pathinfo($originalName, PATHINFO_FILENAME);
                $filename = (new ImageUploadHelper())->uploadImage($file, '/public/uploads/news-images', $originalName);
            }

            $news->update([
                'title' => $request->title,
                'thumbnail' => $filename,
                'content' => $request->description
            ]);

            DB::commit();
            return redirect()->route('website.news.index')->with('success', 'News updated successfully');


        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('website.news.index')->with('error', 'Something went wrong');
        }
    }

    public function delete($newsId){
        DB::beginTransaction(); // Start the transaction
        try {
            $news = News::find($newsId);

            // Check if the news item actually exists
            if (!$news) {
                DB::rollBack(); // Rollback the transaction as a precaution
                return response()->json(['status' => 'error', 'message' => 'News not found'], 404);
            }

            // Adjust the path for the correct folder structure
            $path = public_path('uploads/news-uploads/') . $news->thumbnail;
            if (file_exists($path)) {
                unlink($path);
            }

            $news->delete();
            DB::commit(); // Commit the transaction
            return response()->json(['status' => 'success', 'message' => 'News deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            Log::error('Failed to delete news: ' . $e->getMessage()); // Optionally log the error for debugging

            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
        }
    }
}
