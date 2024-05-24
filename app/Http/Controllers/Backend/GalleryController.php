<?php

namespace App\Http\Controllers\Backend;

use App\Models\GalleryImages;
use Illuminate\Http\Request;
use App\Models\GalleryCategory;
use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{

    public function index(Request $request){

        if($request->ajax()){
            $categories = GalleryCategory::orderBy('created_at', 'desc')->get();

            return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('thumbnail', function($row){
                $url = url('/storage/uploads/category-images/'.$row->thumbnail);
                return "<img src='{$url}' alt='Category thumbnail' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })
            ->addColumn('status', function($row){
                if($row->active_status == true){
                    return "<span class='badge badge-sm badge-success'>Active</span>";
                }else{
                    return "<span class='badge badge-sm badge-danger'>In-active</span>";
                }
            })
            ->addColumn('action', function($row){
                $editUrl = route('website.gallery.category.edit', $row->slug);
                $btns = "";
                if(auth('web')->user()->hasPermissionTo('webContent-delete')){
                    $btns = $btns.' '."<button class='btn btn-sm btn-danger' onclick='deleteCategory({$row->id})'><i class='las la-trash'></i> Delete</button>";
                    $btns = $btns.' '."<a href='{$editUrl}'><button class='btn btn-sm btn-primary'><i class='las la-edit'></i> Edit</button></a>";
                }
                if(auth('web')->user()->hasPermissionTo('webContent-update')){
                    if($row->active_status == true){
                        $btns = $btns.' '."<button class='btn btn-sm btn-danger' onclick='toggleCategoryStatus({$row->id})'><i class='las la-sync'></i> Set In-active</button>";
                    }else{
                        $btns = $btns.' '."<button class='btn btn-sm btn-success' onclick='toggleCategoryStatus({$row->id})'><i class='las la-sync'></i> Set Active</button>";
                    }
                }
                return $btns;

            })
            ->rawColumns(['DT_RowIndex', 'thumbnail', 'status', 'active', 'action'])->make(true);
        }
        return view('backend.website.gallery.category.index');
    }

    public function createCategory(){
        $category = new GalleryCategory();
        return view('backend.website.gallery.category.form', compact('category'));
    }
    public function editCategory($slug){
        $category = GalleryCategory::where('slug', $slug)->first();
        return view('backend.website.gallery.category.form', compact('category'));
    }

    public function storeCategory(Request $request){

        $request->validate([
            'category_name' => 'required|unique:gallery_categories,category_name',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,gif|max:4048'
        ]);

        DB::beginTransaction();
        try{

            $file = $request->file('thumbnail');
            $originalName = $file->getClientOriginalName();
            $originalName = pathinfo($originalName, PATHINFO_FILENAME);
            $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/category-images', $originalName);

            GalleryCategory::create([
                'category_name' => $request->category_name,
                'thumbnail' => $filename
            ]);

            DB::commit();
            return redirect()->route('website.gallery.category.index')->with('success', 'Category added successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }
    public function updateCategory(Request $request, $catId){

        $request->validate([
            'category_name' => 'required|unique:gallery_categories,category_name,'.$catId.',id',
            'thumbnail' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:4048'
        ]);

        DB::beginTransaction();
        try{

            $category = GalleryCategory::find($catId);

            $filename = $category->thumbnail;
            if($request->hasFile('thumbnail')){
                $file = $request->file('thumbnail');
                $originalName = $file->getClientOriginalName();
                $originalName = pathinfo($originalName, PATHINFO_FILENAME);
                $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/category-images', $originalName);
            }

            $category->update([
                'category_name' => $request->category_name,
                'thumbnail' => $filename
            ]);


            DB::commit();
            return redirect()->route('website.gallery.category.index')->with('success', 'Category updated successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function toggleCategoryStatus($catId){

        $category = GalleryCategory::find($catId);
        DB::beginTransaction();
        try{
            $category->update([
                'active_status' => !$category->active_status
            ]);
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Status changed successfully']);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }

    public function deleteCategory($catId){
        $category = GalleryCategory::find($catId);
        DB::beginTransaction();
        try{
            $path = public_path('storage/public/uploads/category-images/').$category->thumbnail;
            if (file_exists($path)) {
                unlink($path);
            }
            $category->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Category deleted successfully']);

        }catch(\Exception $e){
            DB::rollBack();
            // return response()->json(['status' => 'error', 'message' => $e]);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }


    public function imageSection(Request $request){
        if($request->ajax()){
            $categories = GalleryCategory::orderBy('created_at', 'desc')->get();

            return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('thumbnail', function($row){
                $url = url('/storage/uploads/category-images/'.$row->thumbnail);
                return "<img src='{$url}' alt='Category thumbnail' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })
            ->addColumn('img_count', function($row){
               return count($row->images);
            })
            ->addColumn('action', function($row){
                $upPageUrl = route('website.gallery.images.imageUploadPage', $row->slug);
                $btns = "<a href='{$upPageUrl}'><button class='btn btn-sm btn-primary'><i class='las la-photo-video'></i> Manage Gallery</button></a>";
                return $btns;

            })
            ->rawColumns(['DT_RowIndex', 'thumbnail', 'img_count', 'action'])->make(true);
        }
        return view('backend.website.gallery.images.index');
    }

    public function imageUploadPage($slug){

        $category = GalleryCategory::where('slug', $slug)->first();
        return view('backend.website.gallery.images.gallery-page', compact('category'));
    }

    public function getImages($catId)
    {
        // $images = GalleryImages::all()->toArray();

        $category = GalleryCategory::find($catId);

        $images = $category->images->toArray();


        if($images){
            foreach($images as $image){
                $tableImages[] = $image['filename'];
            }
        }else{
            $tableImages = [];
        }


        $storeFolder = public_path('storage/public/uploads/gallery-images');
        $file_path = public_path('storage/public/uploads/gallery-images/');
        $files = scandir($storeFolder);
        $data = null;

        foreach ($files as $file ) {
            if ($file != '.' && $file != '..' && in_array($file,$tableImages)) {
                $obj['name'] = $file;
                $file_path = public_path('storage/public/uploads/gallery-images/').$file;
                $obj['size'] = filesize($file_path);
                $obj['path'] = url('/storage/public/uploads/gallery-images/'.$file);
                $data[] = $obj;
                // return response()->json($data);

            }

        }
        return response()->json($data);
    }

    public function store(Request $request, $catId)
    {
        $image = $request->file('file');
        $fileInfo = $image->getClientOriginalName();
        $filename = pathinfo($fileInfo, PATHINFO_FILENAME);
        $extension = pathinfo($fileInfo, PATHINFO_EXTENSION);
        $file_name= $filename.'-'.time().'.'.$extension;
        $image->storeAs('public/uploads/gallery-images', $file_name);

        $imageUpload = new GalleryImages;
        $imageUpload->original_filename = $fileInfo;
        $imageUpload->filename = $file_name;
        $imageUpload->category_id = $catId;
        $imageUpload->save();
        return response()->json(['success'=>$file_name]);
    }

    public function destroy(Request $request)
    {
        $filename =  $request->get('filename');
        GalleryImages::where('filename',$filename)->delete();
        $path = public_path('storage/public/uploads/gallery-images/').$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success'=>$filename]);
    }
}
