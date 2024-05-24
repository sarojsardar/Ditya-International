<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class LanguageController extends Controller
{
    public function index(Request $request){

        if($request->ajax()){
            $languages = Language::orderBy('created_at', 'desc')->get();
            return DataTables::of($languages)
                ->addIndexColumn()
                ->addColumn('content', function($row){
                    return Str::limit($row->content, 50, $end='...');
                })
                ->addColumn('action', function($row){
                    $editUrl = route('language.edit', $row->slug);
                    $btns = "";
                    if(auth('web')->user()->hasPermissionTo('webContent-delete')){
                        $btns = $btns.' '."<button class='btn btn-sm btn-danger' onclick='deleteLanguage({$row->id})'><i class='las la-trash'></i> Delete</button>";
                    }
                    if(auth('web')->user()->hasPermissionTo('webContent-update')){
                        $btns = $btns.' '."<a href='{$editUrl}'><button class='btn btn-sm btn-primary'><i class='las la-edit'></i> Edit</button></a>";
                    }
                    return $btns;
                })
                ->rawColumns(['DT_RowIndex', 'content', 'action'])
                ->make(true);
        }
        return view('backend.pages.language.index');
    }

    public function create(){
        $languages = new Language();
        return view('backend.pages.language.form', compact('languages'));
    }
    public function edit($slug){
        $languages = Language::where('slug', $slug)->first();
        return view('backend.pages.language.form', compact('languages'));
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|unique:languages,name',
        ]);



        DB::beginTransaction();
        try{

            Language::create([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('language.index')->with('success', 'language added successfully');


        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('language.index')->with('error', 'Something went wrong');
        }

    }

    public function update(Request $request, $languageId){
        $request->validate([
            'name' => 'required|unique:languages,name,'.$languageId.',id',
        ]);

        $languages = Language::find($languageId);

        DB::beginTransaction();
        try{

            $languages->update([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('languages.index')->with('success', 'Language updated successfully');


        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('categories.index')->with('error', 'Something went wrong');
        }
    }

    public function delete($languageId){
        try{

            $languages = Language::find($languageId);

            $languages->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Language deleted successfully']);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }
}
