<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ClientMessages;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClientMessageController extends Controller
{
    
    public function index(Request $request){

        if($request->ajax()){
            $messages = ClientMessages::orderBy('created_at', 'desc')->get();

            return DataTables::of($messages)
            ->addIndexColumn()
            ->addColumn('sent_date', function($row){
                return Carbon::parse(@$row->created_at)->format('Y , d M');
            })
            ->addColumn('status', function($row){
                if($row->read_status == true){
                    return "<span class='badge badge-sm badge-success'>Read</span>";
                }else{
                    return "<span class='badge badge-sm badge-danger'>Unread</span>";
                }
            })
            ->addColumn('action', function($row){
                if($row->read_status == false){
                    return "<button class='btn btn-sm btn-primary' onclick='markMessageRead({$row->id})'><i class='las la-check-double'></i> Mark Read</button>";
                }else{
                    return null;
                }
            })
            ->rawColumns(['DT_RowIndex', 'sent_date', 'status', 'action'])
            ->make(true);
        }

        return view('backend.website.client-messages.index');
    }

    public function storeClientMessage(Request $request){

        $request->validate([
            'name' => 'required',
            'subject' => 'required',
            'email' => 'required|email',
            'contact' => 'required|numeric|digits:10',
            'message' => 'required'
        ]);

        DB::beginTransaction();
        try{

            ClientMessages::create([
                'name' => $request->name,
                'subject' => $request->subject,
                'email' => $request->email,
                'contact' => $request->contact,
                'message' => $request->message,
            ]);

            DB::commit();
            return redirect()->route('web.contactUs')->with('success', 'Message sent to Ditya International');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function markRead($msgId){
        DB::beginTransaction();
        try{

            $msg = ClientMessages::find($msgId);

            $msg->update([
                'read_status' => true
            ]);

            DB::commit();
            return response()->json(['status' => 'success', 'Marked read!']);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'Something went wrong!']);
        }
    }
}
