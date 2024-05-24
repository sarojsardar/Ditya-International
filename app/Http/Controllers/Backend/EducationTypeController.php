<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EducationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EducationTypeController extends Controller
{
    public function index(Request $request){

        if($request->ajax()){
            $educationType = EducationType::orderBy('created_at', 'desc')->get();
            return DataTables::of($educationType)
                ->addIndexColumn()
                ->addColumn('content', function($row){
                    return Str::limit($row->content, 50, $end='...');
                })
                ->addColumn('action', function($row){
                    $editUrl = route('education.types.edit', $row->slug);
                    $btns = "";
                    if(auth('web')->user()->hasPermissionTo('webContent-delete')){
                        $btns = $btns.' '."<button class='btn btn-sm btn-danger' onclick='deleteEducation({$row->id})'><i class='las la-trash'></i> Delete</button>";
                    }
                    if(auth('web')->user()->hasPermissionTo('webContent-update')){
                        $btns = $btns.' '."<a href='{$editUrl}'><button class='btn btn-sm btn-primary'><i class='las la-edit'></i> Edit</button></a>";
                    }
                    return $btns;
                })
                ->rawColumns(['DT_RowIndex', 'content', 'action'])
                ->make(true);
        }
        return view('backend.pages.education-type.index');
    }

    public function create(){
        $educationType = new EducationType();
        return view('backend.pages.education-type.form', compact('educationType'));
    }
    public function edit($slug){
        $educationType = EducationType::where('slug', $slug)->first();
        return view('backend.pages.education-type.form', compact('educationType'));
    }

    public function store(Request $request){


        $request->validate([
            'name' => 'required|unique:education_types,name',
            'edu_level' => 'required'
        ]);

        DB::beginTransaction();
        try{

            EducationType::create([
                'name' => $request->name,
                'edu_level' => $request->edu_level,
            ]);

            DB::commit();
            return redirect()->route('education.types.index')->with('success', 'Education added successfully');


        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('education.types.index')->with('error', 'Something went wrong');
        }

    }

    public function update(Request $request, $educationId){
        $request->validate([
            'name' => 'required|unique:education_types,name,'.$educationId.',id',
        ]);

        $education_types = EducationType::find($educationId);

        DB::beginTransaction();
        try{

            $education_types->update([
                'name' => $request->name,
                'edu_level' => $request->edu_level
            ]);

            DB::commit();
            return redirect()->route('education.types.index')->with('success', 'Education updated successfully');


        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('education.types.index')->with('error', 'Something went wrong');
        }
    }

    public function delete($educationId){
        try{

            $education_types = EducationType::find($educationId);

            $education_types->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Education deleted successfully']);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }
}
