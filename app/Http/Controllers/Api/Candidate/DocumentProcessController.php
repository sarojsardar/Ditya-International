<?php

namespace App\Http\Controllers\Api\Candidate;

use Illuminate\Http\Request;
use App\Action\DocumentAction;
use App\Models\CompanyCandidate;
use App\Http\Controllers\Controller;
use App\Models\Candidate\DocumentProcess;

class DocumentProcessController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $documentProcessess = DocumentProcess::where('user_id', $user->id)->latest()->get();
        return response()->json([
            'message'=>'Document Process List',
            'data'=>$documentProcessess,
            'status'=>200
        ], 200);
    }

    public function show($processId)
    {
        $user = auth()->user();
        $documentProcessess = DocumentProcess::where('user_id', $user->id)->where('id', $processId)->latest()->first();
        return response()->json([
            'message'=>'Document Process List',
            'data'=>$documentProcessess,
            'status'=>200
        ], 200);
    }
    public function uploadDocument(Request $request, $processId)
    {
        try {
            $documentProcessess = DocumentProcess::where('id', $processId)->latest()->first();
            $companyCandidate = CompanyCandidate::where([
                'user_id'=>$documentProcessess->user_id,
                'company_id'=>$documentProcessess->company_id,
                'demand_id'=>$documentProcessess->demand_id,
            ])->latest()->first();
            (new DocumentAction($request))->uplodaAllDocument($companyCandidate);
            return response()->json([
                        'messsage'=>'Successfully Uploaded',
            ], 200);
        } catch (\Throwable $th) {
            info($th->getMessage());
              return response()->json([
                        'messsage'=>$th->getMessage(),
            ], 500);
            return back();
        }
    }
}
