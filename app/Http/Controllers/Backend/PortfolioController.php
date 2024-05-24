<?php

namespace App\Http\Controllers\Backend;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PortfolioController extends Controller
{
    public function index(Request $request){

        $portfolios = Portfolio::orderBy('created_at', 'desc')->get();

        if($request->ajax()){

            return DataTables::of($portfolios)
            ->addIndexColumn()
            ->addColumn('image', function($row){
                $img =  url('/storage/uploads/portfolio/'.$row->image);
                return "<img src='{$img}' alt='portfolio' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })
            ->addColumn('action', function($row){
                $deleteUrl = route('website.portfolio.delete', $row->id);
                return "<div>
                <a href='$deleteUrl' title='Info'><button class='btn btn-sm btn-danger'><i class='fas fa-trash'></i>Delete</button></a>
                </div>";

            })
            ->rawColumns(['DT_RowIndex', 'action', 'image'])
            ->make(true);
        }
        return view('backend.website.portfolio.index');

    }

    public function create(){
        return view('backend.website.portfolio.form');
    }

    public function store(Request $request){

        $request->validate([
            'portfolio' => 'required',
            'portfolio.*' => 'image|mimes:jpg,jpeg,png,gif|max:4048',
        ]);

        DB::beginTransaction();

        try{

            $files = $request->file('portfolio');

            foreach($files as $key => $file){
                $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/portfolio', $key);

                Portfolio::create([
                    'image' => $filename
                ]);
            }

            DB::commit();
            return redirect()->route('website.portfolio.index')->with('success', 'Portfolio added successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('website.portfolio.create')->with('error', 'Something went wrong');
        }
    }

    public function delete($id)
    {
        $portfolio = Portfolio::find($id);

        if (!$portfolio) {
            return redirect()->route('website.portfolio.index')->with('error', 'Record not found');
        }

        DB::beginTransaction();

        try {
            // Assuming 'image' contains just the filename and you're using the 'public' disk
            $path = 'uploads/portfolio/' . $portfolio->image; // Path relative to the disk root

            // Delete the image file using Laravel's Storage facade
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            } else {
                Log::info("File does not exist or has already been deleted: $path");
            }

            $portfolio->delete();

            DB::commit();
            return redirect()->route('website.portfolio.index')->with('success', 'Portfolio deleted successfully');
        } catch (\Exception $e) {
            Log::error('Failed to delete portfolio: ' . $e->getMessage());
            DB::rollBack();
            return redirect()->route('website.portfolio.index')->with('error', 'Something went wrong');
        }
    }
}
