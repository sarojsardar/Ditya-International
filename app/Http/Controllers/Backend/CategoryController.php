<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request){

        if($request->ajax()){
            $category = Category::orderBy('created_at', 'desc')->get();
            return DataTables::of($category)
                ->addIndexColumn()
                ->addColumn('content', function($row){
                    return Str::limit($row->content, 50, $end='...');
                })
                ->addColumn('action', function($row){
                    $editUrl = route('categories.edit', $row->slug);
                    $btns = "";
                    if(auth('web')->user()->hasPermissionTo('webContent-delete')){
                        $btns = $btns.' '."<button class='btn btn-sm btn-danger' onclick='deleteCategory({$row->id})'><i class='las la-trash'></i> Delete</button>";
                    }
                    if(auth('web')->user()->hasPermissionTo('webContent-update')){
                        $btns = $btns.' '."<a href='{$editUrl}'><button class='btn btn-sm btn-primary'><i class='las la-edit'></i> Edit</button></a>";
                    }
                    return $btns;
                })
                ->rawColumns(['DT_RowIndex', 'content', 'action'])
                ->make(true);
        }
        return view('backend.pages.category.index');
    }

    public function create(){
        $categories = new Category();
        return view('backend.pages.category.form', compact('categories'));
    }
    public function edit($slug){
        $categories = Category::where('slug', $slug)->first();
        return view('backend.pages.category.form', compact('categories'));
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);



        DB::beginTransaction();
        try{

            Category::create([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('categories.index')->with('success', 'Category added successfully');


        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('categories.index')->with('error', 'Something went wrong');
        }

    }

    public function update(Request $request, $categoriesId){
        $request->validate([
            'name' => 'required|unique:categories,name,'.$categoriesId.',id',
        ]);

        $categories = Category::find($categoriesId);

        DB::beginTransaction();
        try{

            $categories->update([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->route('categories.index')->with('success', 'Category updated successfully');


        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('categories.index')->with('error', 'Something went wrong');
        }
    }

    public function delete($categoriesId){
        try{

            $categories = Category::find($categoriesId);

            $categories->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Category deleted successfully']);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }
}
