<?php

namespace App\Http\Controllers\Backend;

use App\Helper\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Splash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SplashController extends Controller
{
    public function index(Request $request){

        $splashs = Splash::orderBy('created_at', 'desc')->get();

        if($request->ajax()){

            return DataTables::of($splashs)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                    $img =  url('/storage/uploads/splashs/'.$row->image);
                    return "<img src='{$img}' alt='slider' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
                })
                ->addColumn('action', function($row){
                    $editUrl = route('website.splash.edit', $row->id);
                    $deleteUrl = route('website.splash.delete', $row->id);
                    return "<div>
                <a href='$editUrl' title='Edit'><button class='btn btn-sm btn-primary'><i class='fas fa-pen'></i>Edit</button></a>
                <a href='$deleteUrl' title='Info'><button class='btn btn-sm btn-danger'><i class='fas fa-trash'></i>Delete</button></a>
                </div>";

                })
                ->rawColumns(['DT_RowIndex', 'action', 'image'])
                ->make(true);
        }
        return view('backend.website.splash.index');

    }

    public function add(){
        $splash = new Splash();

        return view('backend.website.splash.form', compact('splash'));
    }

    public function edit($id){
        $splash = Splash::find($id);
        return view('backend.website.splash.form', compact('splash'));
    }

    public function store(Request $request){

        $request->validate([
            'image'=> 'required|image|mimes:jpg,jpeg,png,gif|max:4048',
            'title' => 'required',
        ]);

        DB::beginTransaction();
        try{

            $image = $request->file('image');
            $splashImg = (new ImageUploadHelper())->uploadImage($image, 'public/uploads/splashs', 'splash');

            Splash::create([
                'title' => $request->title,
                'image' => $splashImg
            ]);

            DB::commit();

            return redirect()->route('website.splash.index')->with('success', 'Splash added successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', $e);
        }
    }
    public function update(Request $request, $id){

        $splash = Splash::find($id);
        $sImage = $splash->image;
        if($request->hasFile('image')){
            $request->validate([
                'image'=> 'image|mimes:jpg,jpeg,png,gif|max:4048',
            ]);

            $image = $request->file('image');
            $sImage = (new ImageUploadHelper())->uploadImage($image, 'public/uploads/splashs', 'splash');

        }
        $request->validate([
            'title' => 'required',
        ]);

        DB::beginTransaction();
        try{

            $splash->update([
                'title' => $request->title,
                'image' => $sImage
            ]);

            DB::commit();

            return redirect()->route('website.splash.index')->with('success', 'Splash updated successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', $e);

        }
    }

    public function delete($id)
    {
        $splash = Splash::find($id);

        if (!$splash) {
            return redirect()->route('website.splash.index')->with('error', 'Record not found.');
        }

        DB::beginTransaction();

        try {
            // Correct the path and use Laravel's Storage facade
            $path = 'uploads/splashs/' . $splash->image; // Assuming 'public' disk is set as default

            // Check if file exists before deletion
            if (Storage::exists($path)) {
                Storage::delete($path);
            } else {
                Log::info("File does not exist or has already been deleted: $path");
            }

            $splash->delete();

            DB::commit();
            return redirect()->route('website.splash.index')->with('success', 'Splash deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete splash: ' . $e->getMessage());
            DB::rollBack();
            return redirect()->route('website.splash.index')->with('error', 'Something went wrong, unable to delete the splash.');
        }
    }
}
