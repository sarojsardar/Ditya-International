<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class GenderController extends Controller
{
    public function index(Request $request){

        if($request->ajax()){
            $gender = Gender::orderBy('created_at', 'desc')->get();
            return DataTables::of($gender)
                ->addIndexColumn()
                ->addColumn('content', function($row){
                    return Str::limit($row->content, 50, $end='...');
                })
                ->addColumn('action', function($row){
                    $editUrl = route('gender.edit', $row->slug);
                    $btns = "";
                    if(auth('web')->user()->hasPermissionTo('webContent-delete')){
                        $btns = $btns.' '."<button class='btn btn-sm btn-danger' onclick='deleteGender({$row->id})'><i class='las la-trash'></i> Delete</button>";
                    }
                    if(auth('web')->user()->hasPermissionTo('webContent-update')){
                        $btns = $btns.' '."<a href='{$editUrl}'><button class='btn btn-sm btn-primary'><i class='las la-edit'></i> Edit</button></a>";
                    }
                    return $btns;
                })
                ->rawColumns(['DT_RowIndex', 'content', 'action'])
                ->make(true);
        }
        return view('backend.pages.gender.index');
    }

    public function create(){
        $genders = new Gender();
        return view('backend.pages.gender.form', compact('genders'));
    }
    public function edit($slug){
        $genders = Gender::where('slug', $slug)->first();
        return view('backend.pages.gender.form', compact('genders'));
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|unique:genders,name',
        ]);

        DB::beginTransaction();
        try{

            Gender::create([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('gender.index')->with('success', 'Gender added successfully');


        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('gender.index')->with('error', 'Something went wrong');
        }

    }

    public function update(Request $request, $genderId){
        $request->validate([
            'name' => 'required|unique:genders,name,'.$genderId.',id',
        ]);

        $genders = Gender::find($genderId);

        DB::beginTransaction();
        try{

            $genders->update([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('gender.index')->with('success', 'Gender updated successfully');


        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('categories.index')->with('error', 'Something went wrong');
        }
    }

    public function delete($genderId){
        try{

            $genders = Gender::find($genderId);

            $genders->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Gender deleted successfully']);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }
}
