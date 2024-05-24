<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{

    public function index(Request $request){

        if($request->ajax()){
            $testimonials = Testimonials::orderBy('created_at', 'desc')->get();

            return DataTables::of($testimonials)
            ->addIndexColumn()
            ->addColumn('message', function($row){
                return Str::limit($row->message, 50, $end='...');
            })
            ->addColumn('image', function($row){
                $url = url('/storage/uploads/testimonial-images/'.$row->image);
                return "<img src='{$url}' alt='Testimonial thumbnail' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })
            ->addColumn('action', function($row){
                $editUrl = route('testimonial.edit', $row->id);
                $btns = "";
                if(auth('web')->user()->hasPermissionTo('webContent-delete')){
                    $btns = $btns.' '."<button class='btn btn-sm btn-danger' onclick='deleteTestimonial({$row->id})'><i class='las la-trash'></i> Delete</button>";
                }
                if(auth('web')->user()->hasPermissionTo('webContent-update')){
                    $btns = $btns.' '."<a href='{$editUrl}'><button class='btn btn-sm btn-primary'><i class='las la-edit'></i> Edit</button></a>";
                }
                return $btns;
            })
            ->rawColumns(['DT_RowIndex', 'image', 'message', 'action'])
            ->make(true);

        }
        return view('backend.website.testimonials.index');
    }

    public function create(){
        $testimonial = new Testimonials();
        return view('backend.website.testimonials.form', compact('testimonial'));
    }

    public function edit($id){
        $testimonial = Testimonials::find($id);
        return view('backend.website.testimonials.form', compact('testimonial'));
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'message' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4048',
        ]);

        DB::beginTransaction();
        try{

            $file = $request->file('image');
            $originalName = $file->getClientOriginalName();
            $originalName = pathinfo($originalName, PATHINFO_FILENAME);
            $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/testimonial-images', $originalName);

            Testimonials::create([
                'name' => $request->name,
                'designation' => $request->designation,
                'message' => $request->message,
                'image' => $filename
            ]);

            DB::commit();
            return redirect()->route('testimonials.index')->with('success', 'Testimonial added successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', 'Something went wrong!');
        }
    }
    public function update(Request $request, $id){

        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'message' => 'required',
            'image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,gif|max:4048',
        ]);

        DB::beginTransaction();
        try{

            $testimonial = Testimonials::find($id);

            $filename = $testimonial->image;
            if($request->hasFile('image')){
                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $originalName = pathinfo($originalName, PATHINFO_FILENAME);
                $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/testimonial-images', $originalName);
            }

            $testimonial->update([
                'name' => $request->name,
                'designation' => $request->designation,
                'message' => $request->message,
                'image' => $filename
            ]);

            DB::commit();
            return redirect()->route('testimonials.index')->with('success', 'Testimonial updated successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', 'Something went wrong!');
        }
    }

    public function delete($id){
        $testimonial = Testimonials::find($id);
        DB::beginTransaction();
        try{
            $path = public_path('storage/public/uploads/testimonial-images/').$testimonial->image;
            if (file_exists($path)) {
                unlink($path);
            }
            $testimonial->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Testimonial deleted successfully']);

        }catch(\Exception $e){
            DB::rollBack();
            // return response()->json(['status' => 'error', 'message' => $e]);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }
}
