<?php

namespace App\Http\Controllers\Backend;

use App\Models\Services;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{

    public function index(Request $request){

        $services = Services::orderBy('created_at', 'desc')->get();

        if($request->ajax()){

            return DataTables::of($services)
            ->addIndexColumn()
            ->addColumn('image', function($row){
                $img =  url('/storage/uploads/services/'.$row->image);
                return "<img src='{$img}' alt='service' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })
            ->addColumn('description', function($row){
                return Str::limit($row->description, 150, $end='...');
            })
            ->addColumn('action', function($row){
                $editUrl = route('website.services.edit', $row->id);
                $deleteUrl = route('website.services.delete', $row->id);
                return "<div>
                <a href='$editUrl' title='Edit'><button class='btn btn-sm btn-primary'><i class='fas fa-pen'></i>Edit</button></a>
                <a href='$deleteUrl' title='Info'><button class='btn btn-sm btn-danger'><i class='fas fa-trash'></i>Delete</button></a>
                </div>";

            })
            ->rawColumns(['DT_RowIndex', 'action', 'description', 'image'])
            ->make(true);
        }

        return view('backend.website.services.index');
    }

    public function create(){
        $service = new Services();
        return view('backend.website.services.form', compact('service'));
    }

    public function edit($id){
        $service = Services::find($id);
        return view('backend.website.services.form', compact('service'));
    }

    public function store(Request $request){

        $request->validate([
            'service_image'=> 'required|image|mimes:jpg,jpeg,png,gif|max:4048',
            'title' => 'required',
            'description' => 'required',
        ]);

        DB::beginTransaction();
        try{

            $image = $request->file('service_image');
            $sliderImg = (new ImageUploadHelper())->uploadImage($image, 'public/uploads/services', 'service');

            Services::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $sliderImg
            ]);

            DB::commit();

            return redirect()->route('website.services.index')->with('success', 'Service added successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('website.services.index')->with('error', 'Something went wrong');
        }

    }

    public function update(Request $request, $id){

        $service = Services::find($id);
        $sImage = $service->image;
        if($request->hasFile('service_image')){

            $request->validate([
                'service_image'=> 'image|mimes:jpg,jpeg,png,gif|max:4048',
            ]);

            $image = $request->file('service_image');
            $sImage = (new ImageUploadHelper())->uploadImage($image, 'public/uploads/services', 'service');

        }
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        DB::beginTransaction();
        try{

            $service->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $sImage
            ]);

            DB::commit();

            return redirect()->route('website.services.index')->with('success', 'Service updated successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('website.services.index')->with('error', 'Something went wrong');
        }
    }

    public function delete($id)
    {
        $service = Services::find($id);

        if (!$service) {
            return redirect()->route('website.services.index')->with('error', 'Record not found');
        }

        DB::beginTransaction();

        try {
            // Assuming the 'public' disk is used and 'image' contains just the filename
            $path = 'uploads/services/' . $service->image; // Path relative to the disk root

            // Delete the image file using Laravel's Storage facade
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            } else {
                Log::info("File does not exist or has already been deleted: $path");
            }

            // Delete the service record
            $service->delete();

            DB::commit();
            return redirect()->route('website.services.index')->with('success', 'Service deleted successfully');
        } catch (\Exception $e) {
            Log::error('Failed to delete service: ' . $e->getMessage());
            DB::rollBack();
            return redirect()->route('website.services.index')->with('error', 'Something went wrong');
        }
    }
}
