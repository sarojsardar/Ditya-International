<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = Notification::where([
            'is_new'=>true,
            'generated_to'=>get_class($user),
            'generated_to_id'=>$user->id,
        ])->orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Notification List',
            'data' => $notifications,
        ], 200);
    }
    public function show(Request $request, $notificationId)
    {
        $user = auth()->user();
        $notification = Notification::where([
            'id'=>$notificationId,
            'generated_to'=>get_class($user),
            'generated_to_id'=>$user->id,
        ])->firstOrFail();
        $notification->is_new = false;
        $notification->save();
        return response()->json([
            'success' => true,
            'message' => 'Notification',
            'data' => $notification->refresh(),
        ], 200);
    }
}