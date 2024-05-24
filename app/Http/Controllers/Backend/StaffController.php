<?php

namespace App\Http\Controllers\Backend;

use App\Enum\UserStatus;
use App\Helper\ImageUploadHelper;
use App\Models\UserInformation;
use Carbon\Carbon;
use App\Models\User;
use App\Enum\UserTypes;
use App\Data\Role\RoleData;
use Illuminate\Http\Request;
use App\Data\Staff\StaffData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
{


    public function index(Request $request){

        $staffs = User::where('id', '!=', auth('web')->id())->where('user_type', UserTypes::NORMAL)->get();

        if($request->ajax()){

            return DataTables::of($staffs)
            ->addIndexColumn()
            ->addColumn('profile', function($row){
                if(@$row->userInfo->profile_picture){
                    $url = url('/storage/uploads/staff-profiles/'.$row->userInfo->profile_picture);
                    return "<img src='{$url}' alt='staff profile' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
                }else{
                    $url = asset('no-profile.jpg');
                    return "<img src='{$url}' alt='staff profile' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
                }            })
            ->addColumn('fullname', function($row){
                return $row->userInfo->first_name.' '.$row->userInfo->middle_name.' '.$row->userInfo->last_name;
            })
            ->addColumn('contact', function($row){
                return $row->userInfo->contact;
            })
            ->addColumn('address', function($row){
                return $row->userInfo->full_address;
            })
            ->addColumn('role', function($row){
                return "<strong>{$row->roles[0]->name }</strong>";
            })
            ->addColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('Y , d M | g:i A');
            })
            ->addColumn('action', function($row){
                $url = route('staff.edit', $row->id);
                if(auth('web')->user()->hasPermissionTo('staff-update')){
                    return "<a href='{$url}' class='btn btn-sm btn-primary'><i class='mdi mdi-file-document-edit-outline'></i> Edit</a>";
                }else{
                    return '';
                }
            })
            ->rawColumns(['DT_RowIndex', 'profile', 'fullname', 'contact', 'address', 'role', 'created_at', 'action'])
            ->make(true);
        }

        return view('backend.pages.staffs.index', compact('staffs'));
    }

    public function create(Request $request){

        $roles = (new RoleData(null))->getAllRoles();
        $staff = new User();
        return view('backend.pages.staffs.form', compact('roles', 'staff'));
    }


    public function edit($staffId){
        $staff = User::find($staffId);
        if(!$staff){
            return redirect()->route('staff.index')->with('error', 'Record not found');
        }
        $roles = (new RoleData(null))->getAllRoles();
        return view('backend.pages.staffs.form', compact('roles', 'staff'));
    }


    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'contact' => 'required|unique:user_information,contact|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'full_address' => 'required',
            'role' => 'required',
            'profile_picture' => 'sometimes|file|mimes:jpg,jpeg,png,bmp,tiff|max:4096', // 'sometimes' conditionally validates the field
        ]);

        DB::beginTransaction();
        try {
            $filename = null;
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/staff-profiles');
            }

            $newStaff = User::create([
                'username' => strtolower($request->first_name) . str_pad(mt_rand(1,9999), 4, '0', STR_PAD_LEFT),
                'email' => $request->email,
                'password' => Hash::make('nepal123'),
                'status' => UserStatus::Active,
            ]);

            $role = Role::findById($request->role);
            $newStaff->assignRole($role);

            UserInformation::create([
                'user_id' => $newStaff->id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name ?? '', // Handle optional middle name
                'last_name' => $request->last_name,
                // 'marital_status' => $request->marital_status ?? '', // Handle optional marital status
                'full_address' => $request->full_address,
                'contact' => $request->contact,
                'profile_picture' => $filename,
            ]);

            DB::commit();

            // Redirect or respond with success
            return redirect()->route('staff.index')->with('success', 'Staff registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception, maybe log it and redirect or respond with error
            return back()->with('error', 'Failed to register staff: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $staffId)
    {
        $staff = User::find($staffId);
        if (!$staff) {
            return redirect()->route('staff.index')->with('error', 'Staff record not found.');
        }

        $infoId = optional($staff->userInfo)->id;

        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $staffId,
            'contact' => 'required|unique:user_information,contact,' . $infoId . '|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'full_address' => 'required',
            'role' => 'required',
            'profile_picture' => 'sometimes|mimes:jpg,jpeg,png,bmp,tiff|max:4096'
        ]);

        DB::beginTransaction();

        try {
            $role = Role::findById($validatedData['role']);
            if (!$role) {
                return back()->with('error', 'Selected role does not exist.');
            }

            $staff->syncRoles([$role->name]);

            if ($request->hasFile('profile_picture')) {
                // Assume your StaffData class handles the profile picture update
                // Ensure the update method in StaffData is capable of handling file uploads
            }

            (new StaffData($request))->update($staff);

            DB::commit();
            return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update staff: ' . $e->getMessage());
        }
    }

}
