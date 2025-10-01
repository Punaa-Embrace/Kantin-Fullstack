<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Get user notifications
     */
    public function apiIndex(Request $request)
    {
        $user = $request->user();
        
        $notifications = Notification::where('user_id', $user->id)
            ->orWhere(function($query) use ($user) {
                // Notifications for specific roles
                if ($user->isTenantManager()) {
                    $query->where('type', 'tenant_order');
                } elseif ($user->isStudent()) {
                    $query->where('type', 'student_order');
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => [
                'notifications' => $notifications->items(),
                'pagination' => [
                    'current_page' => $notifications->currentPage(),
                    'total_pages' => $notifications->lastPage(),
                    'total_items' => $notifications->total(),
                    'per_page' => $notifications->perPage(),
                ]
            ]
        ]);
    }

    /**
     * Send notification to user
     */
    public function apiSendNotification(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:order,payment,system,promotion',
            'data' => 'sometimes|array'
        ]);

        $notification = Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'data' => $request->data ?? [],
            'read_at' => null,
        ]);

        // Send FCM notification if user has FCM token
        $user = User::find($request->user_id);
        if ($user && $user->fcm_token) {
            $this->sendFcmNotification(
                $user->fcm_token,
                $request->title,
                $request->message,
                $request->data ?? []
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Notification sent successfully',
            'data' => $notification
        ]);
    }

    /**
     * Mark notification as read
     */
    public function apiMarkAsRead(Request $request, $id)
    {
        $notification = Notification::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $notification->update([
            'read_at' => Carbon::now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
            'data' => $notification
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function apiMarkAllAsRead(Request $request)
    {
        Notification::where('user_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => Carbon::now()]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    /**
     * Get unread notifications count
     */
    public function apiUnreadCount(Request $request)
    {
        $count = Notification::where('user_id', $request->user()->id)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'unread_count' => $count
            ]
        ]);
    }

    /**
     * Delete notification
     */
    public function apiDestroy(Request $request, $id)
    {
        $notification = Notification::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully'
        ]);
    }

    /**
     * Send FCM notification
     */
    private function sendFcmNotification($token, $title, $body, $data = [])
    {
        // Implement FCM notification sending
        // You'll need to install and configure firebase/php-jwt and guzzlehttp/guzzle
        
        try {
            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
            
            $notification = [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
                'badge' => '1',
            ];

            $fcmNotification = [
                'to' => $token,
                'notification' => $notification,
                'data' => $data
            ];

            $headers = [
                'Authorization: key=' . env('FCM_SERVER_KEY'),
                'Content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch);

            \Log::info('FCM Notification Sent', [
                'token' => $token,
                'result' => $result
            ]);

            return $result;

        } catch (\Exception $e) {
            \Log::error('FCM Notification Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update user FCM token
     */
    public function apiUpdateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string'
        ]);

        $user = $request->user();
        $user->fcm_token = $request->fcm_token;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'FCM token updated successfully'
        ]);
    }
}