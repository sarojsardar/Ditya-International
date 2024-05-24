<?php

namespace App\Http\Controllers\Backend;

use App\Models\Sliders;
use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{

    public function index(Request $request){

        $sliders = Sliders::orderBy('created_at', 'desc')->get();

        if($request->ajax()){

            return DataTables::of($sliders)
            ->addIndexColumn()
            ->addColumn('image', function($row){
                $img =  url('/storage/uploads/sliders/'.$row->image);
                return "<img src='{$img}' alt='slider' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })
            ->addColumn('description', function($row){
                return $row->description;
            })
            ->addColumn('action', function($row){
                $editUrl = route('website.slider.edit', $row->id);
                $deleteUrl = route('website.slider.delete', $row->id);
                return "<div>
                <a href='$editUrl' title='Edit'><button class='btn btn-sm btn-primary'><i class='fas fa-pen'></i>Edit</button></a>
                <a href='$deleteUrl' title='Info'><button class='btn btn-sm btn-danger'><i class='fas fa-trash'></i>Delete</button></a>
                </div>";

            })
            ->rawColumns(['DT_RowIndex', 'action', 'description', 'image'])
            ->make(true);
        }
        return view('backend.website.sliders.index');

    }

    public function add(){
        $slider = new Sliders();

        return view('backend.website.sliders.form', compact('slider'));
    }

    public function edit($id){
        $slider = Sliders::find($id);
        return view('backend.website.sliders.form', compact('slider'));
    }

    public function store(Request $request){

        $request->validate([
            'slider_image'=> 'required|image|mimes:jpg,jpeg,png,gif|max:4048',
            'title' => 'required',
        ]);

        DB::beginTransaction();
        try{

            $image = $request->file('slider_image');
            $sliderImg = (new ImageUploadHelper())->uploadImage($image, 'public/uploads/sliders', 'slider');

            Sliders::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $sliderImg
            ]);

            DB::commit();

            return redirect()->route('website.slider.index')->with('success', 'Slider added successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', $e);

        }
    }
    public function update(Request $request, $id){

        $slider = Sliders::find($id);
        $sImage = $slider->image;
        if($request->hasFile('slider_image')){
            $request->validate([
                'slider_image'=> 'image|mimes:jpg,jpeg,png,gif|max:4048',
            ]);

            $image = $request->file('slider_image');
            $sImage = (new ImageUploadHelper())->uploadImage($image, 'public/uploads/sliders', 'slider');

        }
        $request->validate([
            'title' => 'required',
        ]);

        DB::beginTransaction();
        try{

            $slider->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $sImage
            ]);

            DB::commit();

            return redirect()->route('website.slider.index')->with('success', 'Slider updated successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', $e);

        }
    }

    public function delete($id)
    {
        $slider = Sliders::find($id);

        if (!$slider) {
            return redirect()->route('website.slider.index')->with('error', 'Record not found.');
        }

        DB::beginTransaction();

        try {
            $path = 'uploads/sliders/' . $slider->image;

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            } else {
                Log::info("File does not exist or has already been deleted: $path");
            }

            $slider->delete();

            DB::commit();

            return redirect()->route('website.slider.index')->with('success', 'Slider deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete slider: ' . $e->getMessage());
            DB::rollBack();

            return redirect()->route('website.slider.index')->with('error', 'Something went wrong, unable to delete the slider.');
        }
    }
}
