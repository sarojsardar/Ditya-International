<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Medical\Medical;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $medicals = Medical::orderBy('created_at', 'desc')->get();

            return DataTables::of($medicals)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return @$row->name;
                })
                ->addColumn('address', function ($row) {
                    return @$row->address;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == true) {
                        return "<span class='badge bg-label-success rounded-pill'>Active</span>";
                    } else {
                        return "<span class='badge bg-label-danger rounded-pill'>In-active</span>";
                    }
                })
                ->addColumn('location', function ($row) {
                    return @$row->location;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('medical.edit', $row->id);
                    $btns = "";
                    if (true) {
                        $btns = $btns . ' ' . "<a href='{$editUrl}'><button class='btn btn-sm btn-primary'><i class='las la-edit'></i> Edit</button></a>";
                    }
                    if (true) {
                        if ($row->status == true) {
                            $btns = $btns . ' ' . "<button class='btn btn-sm btn-danger' onclick='toggleMedicalStatus({$row->id})'><i class='las la-sync'></i> Set In-active</button>";
                        } else {
                            $btns = $btns . ' ' . "<button class='btn btn-sm btn-success' onclick='toggleMedicalStatus({$row->id})'><i class='las la-sync'></i> Set Active</button>";
                        }
                    }
                    return $btns;
                })
                ->rawColumns(['DT_RowIndex', 'thumbnail', 'status', 'active', 'action'])->make(true);
        }

        return view('backend.pages.medical.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medical = new Medical();
        return view('backend.pages.medical.form', compact('medical'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'location' => 'required',
        ]);

        try {

            $data = [
                'name' => $validated['name'],
                'address' => $validated['address'],
                'location' => $validated['location'],
            ];

            Medical::create($data);

            return redirect()->route('medical.index')->with('success', 'Medical added successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $medical = Medical::findOrFail($id);
        return view('backend.pages.medical.form', compact('medical'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $medical = Medical::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'location' => 'required',
        ]);

        try {

            $data = [
                'name' => $validated['name'],
                'address' => $validated['address'],
                'location' => $validated['location'],
            ];

            $medical->update($data);

            return redirect()->route('medical.index')->with('success', 'Medical added successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e);
        }
    }

    public function toggleMedicalStatus($id)
    {
        $medical = Medical::findOrFail($id);

        try {
            $medical->update([
                'status' => !$medical->status
            ]);
            return response()->json(['status' => 'success', 'message' => 'Status changed successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }
}
