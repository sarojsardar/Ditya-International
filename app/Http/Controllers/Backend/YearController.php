<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class YearController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $years = Year::orderBy('created_at', 'desc')->get();
            return DataTables::of($years)
                ->addIndexColumn()
                ->addColumn('year', function($row){
                    // Assuming $row->name holds the year's name
                    $yearNameWithSuffix = $row->name . ' Years';
                    return Str::limit($yearNameWithSuffix, 50, $end='...');
                })
                ->addColumn('content', function($row){
                    // Assuming $row->content holds additional content where you also want to add ' years'
                    $contentWithSuffix = $row->content ;
                    return Str::limit($contentWithSuffix, 50, $end='...');
                })
                ->addColumn('action', function($row){
                    $editUrl = route('year.edit', $row->slug);
                    $btns = "";
                    if(auth('web')->user()->hasPermissionTo('webContent-delete')){
                        $btns .= "<button class='btn btn-sm btn-danger' onclick='deleteYear({$row->id})'><i class='las la-trash'></i> Delete</button> ";
                    }
                    if(auth('web')->user()->hasPermissionTo('webContent-update')){
                        $btns .= "<a href='{$editUrl}' class='btn btn-sm btn-primary'><i class='las la-edit'></i> Edit</a>";
                    }
                    return $btns;
                })
                ->rawColumns(['DT_RowIndex', 'year', 'content', 'action'])
                ->make(true);
        }
        return view('backend.pages.year.index');
    }


    public function create(){

        $years = new Year();
        return view('backend.pages.year.form', compact('years'));
    }
    public function edit($slug){
        $years = Year::where('slug', $slug)->first();
        return view('backend.pages.year.form', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:years,name',
        ]);

        DB::beginTransaction();
        try{

            Year::create([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('year.index')->with('success', 'Year added successfully');


        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('year.index')->with('error', 'Something went wrong');
        }
    }


    public function update(Request $request, $yearId){
        $request->validate([
            'name' => 'required|unique:years,name,'.$yearId.',id',
        ]);

        $years = Year::find($yearId);

        DB::beginTransaction();
        try{

            $years->update([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('year.index')->with('success', 'Year updated successfully');


        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('year.index')->with('error', 'Something went wrong');
        }
    }

    public function delete($yearId){
        try{

            $years = Year::find($yearId);
            $years->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Year deleted successfully']);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }
}
