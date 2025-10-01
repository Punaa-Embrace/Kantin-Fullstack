<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeliveryController extends Controller
{
    /**
     * Track order delivery
     */
    public function apiTrackOrder(Request $request, $orderCode)
    {
        $order = Order::where('order_code', $orderCode)
            ->with(['delivery.driver', 'student', 'tenant'])
            ->firstOrFail();

        // Check if user has permission to view this order
        $user = $request->user();
        if (!$this->canViewOrder($user, $order)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to view this order'
            ], 403);
        }

        $trackingInfo = $this->buildTrackingInfo($order);

        return response()->json([
            'success' => true,
            'data' => [
                'order' => $order,
                'tracking' => $trackingInfo
            ]
        ]);
    }

    /**
     * Update delivery location (for drivers)
     */
    public function apiUpdateLocation(Request $request)
    {
        $request->validate([
            'order_code' => 'required|exists:orders,order_code',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'sometimes|string'
        ]);

        $order = Order::where('order_code', $request->order_code)
            ->with('delivery')
            ->firstOrFail();

        // Check if user is the delivery driver
        if ($order->delivery->driver_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update location for this order'
            ], 403);
        }

        // Update delivery location
        $order->delivery->update([
            'current_latitude' => $request->latitude,
            'current_longitude' => $request->longitude,
            'current_address' => $request->address,
            'location_updated_at' => Carbon::now()
        ]);

        // Create location history
        DB::table('delivery_location_history')->insert([
            'delivery_id' => $order->delivery->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Location updated successfully',
            'data' => [
                'location' => [
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'address' => $request->address,
                    'updated_at' => Carbon::now()
                ]
            ]
        ]);
    }

    /**
     * Get delivery driver info
     */
    public function apiGetDriver(Request $request, $orderCode)
    {
        $order = Order::where('order_code', $orderCode)
            ->with(['delivery.driver'])
            ->firstOrFail();

        // Check if user has permission to view this order
        $user = $request->user();
        if (!$this->canViewOrder($user, $order)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to view this order'
            ], 403);
        }

        $driver = $order->delivery->driver;

        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'No driver assigned to this order yet'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'driver' => [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'phone' => $driver->phone,
                    'avatar' => $driver->getFirstMediaUrl('profile_photo'),
                    'vehicle_type' => $driver->vehicle_type ?? 'Motor',
                    'vehicle_number' => $driver->vehicle_number,
                    'rating' => $driver->rating ?? 5.0,
                ],
                'current_location' => [
                    'latitude' => $order->delivery->current_latitude,
                    'longitude' => $order->delivery->current_longitude,
                    'address' => $order->delivery->current_address,
                    'updated_at' => $order->delivery->location_updated_at
                ]
            ]
        ]);
    }

    /**
     * Get delivery estimation
     */
    public function apiGetEstimation(Request $request, $orderCode)
    {
        $order = Order::where('order_code', $orderCode)
            ->with(['delivery'])
            ->firstOrFail();

        $estimation = $this->calculateDeliveryEstimation($order);

        return response()->json([
            'success' => true,
            'data' => [
                'estimation' => $estimation
            ]
        ]);
    }

    /**
     * Update delivery status
     */
    public function apiUpdateStatus(Request $request, $orderCode)
    {
        $request->validate([
            'status' => 'required|in:picked_up,on_the_way,arrived,completed,cancelled'
        ]);

        $order = Order::where('order_code', $orderCode)
            ->with('delivery')
            ->firstOrFail();

        // Check if user is the delivery driver or tenant manager
        $user = $request->user();
        if (!$this->canUpdateDeliveryStatus($user, $order)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update delivery status'
            ], 403);
        }

        DB::transaction(function () use ($order, $request) {
            // Update delivery status
            $order->delivery->update([
                'status' => $request->status,
                'status_updated_at' => Carbon::now()
            ]);

            // Update order status based on delivery status
            $orderStatus = $this->mapDeliveryToOrderStatus($request->status);
            if ($orderStatus) {
                $order->update(['status' => $orderStatus]);
            }

            // Create status history
            DB::table('delivery_status_history')->insert([
                'delivery_id' => $order->delivery->id,
                'status' => $request->status,
                'notes' => $request->notes,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Send notification to student
            $this->sendDeliveryStatusNotification($order, $request->status);
        });

        return response()->json([
            'success' => true,
            'message' => 'Delivery status updated successfully',
            'data' => [
                'delivery_status' => $request->status,
                'order_status' => $order->status
            ]
        ]);
    }

    /**
     * Get delivery history for an order
     */
    public function apiGetDeliveryHistory(Request $request, $orderCode)
    {
        $order = Order::where('order_code', $orderCode)
            ->with(['delivery.statusHistory', 'delivery.locationHistory'])
            ->firstOrFail();

        // Check if user has permission to view this order
        $user = $request->user();
        if (!$this->canViewOrder($user, $order)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to view this order'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'status_history' => $order->delivery->statusHistory,
                'location_history' => $order->delivery->locationHistory
            ]
        ]);
    }

    /**
     * Helper: Check if user can view order
     */
    private function canViewOrder($user, $order)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isStudent() && $order->student_id === $user->id) {
            return true;
        }

        if ($user->isTenantManager() && $order->tenant->user_id === $user->id) {
            return true;
        }

        if ($order->delivery && $order->delivery->driver_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Helper: Check if user can update delivery status
     */
    private function canUpdateDeliveryStatus($user, $order)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($order->delivery && $order->delivery->driver_id === $user->id) {
            return true;
        }

        if ($user->isTenantManager() && $order->tenant->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Helper: Build tracking information
     */
    private function buildTrackingInfo($order)
    {
        $statusTimeline = [
            'order_placed' => $order->created_at,
            'order_confirmed' => $order->confirmed_at,
            'food_prepared' => $order->prepared_at,
            'picked_up' => $order->delivery->picked_up_at ?? null,
            'on_the_way' => $order->delivery->on_the_way_at ?? null,
            'arrived' => $order->delivery->arrived_at ?? null,
            'completed' => $order->delivery->completed_at ?? null,
        ];

        $currentStatus = $order->delivery->status ?? 'pending';
        $estimatedTime = $this->calculateDeliveryEstimation($order);

        return [
            'status' => $currentStatus,
            'status_string' => $this->getStatusString($currentStatus),
            'timeline' => $statusTimeline,
            'estimated_delivery_time' => $estimatedTime,
            'current_location' => [
                'latitude' => $order->delivery->current_latitude ?? null,
                'longitude' => $order->delivery->current_longitude ?? null,
                'address' => $order->delivery->current_address ?? null,
            ],
            'pickup_location' => [
                'name' => $order->tenant->name,
                'address' => $order->tenant->address,
            ],
            'delivery_location' => [
                'name' => $order->student->name,
                'address' => $order->delivery_address,
            ]
        ];
    }

    /**
     * Helper: Calculate delivery estimation
     */
    private function calculateDeliveryEstimation($order)
    {
        // Simple estimation logic - you can replace with more complex algorithm
        $baseTime = 15; // 15 minutes base
        $distanceTime = 10; // Assume 10 minutes for distance
        $trafficTime = 5; // Assume 5 minutes for traffic

        $totalMinutes = $baseTime + $distanceTime + $trafficTime;
        
        return Carbon::now()->addMinutes($totalMinutes);
    }

    /**
     * Helper: Map delivery status to order status
     */
    private function mapDeliveryToOrderStatus($deliveryStatus)
    {
        $mapping = [
            'picked_up' => 'on_delivery',
            'on_the_way' => 'on_delivery',
            'arrived' => 'arrived',
            'completed' => 'completed',
            'cancelled' => 'cancelled'
        ];

        return $mapping[$deliveryStatus] ?? null;
    }

    /**
     * Helper: Get status string for display
     */
    private function getStatusString($status)
    {
        $statuses = [
            'pending' => 'Menunggu Konfirmasi',
            'picked_up' => 'Pesanan Diambil',
            'on_the_way' => 'Sedang Diantar',
            'arrived' => 'Tiba di Lokasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        return $statuses[$status] ?? 'Tidak Dikenal';
    }

    /**
     * Helper: Send delivery status notification
     */
    private function sendDeliveryStatusNotification($order, $status)
    {
        $statusMessages = [
            'picked_up' => 'Pesanan Anda telah diambil oleh kurir dan sedang menuju ke Anda',
            'on_the_way' => 'Pesanan Anda sedang dalam perjalanan',
            'arrived' => 'Kurir telah tiba di lokasi Anda',
            'completed' => 'Pesanan Anda telah selesai',
            'cancelled' => 'Pengantaran pesanan Anda dibatalkan'
        ];

        $message = $statusMessages[$status] ?? 'Status pengantaran pesanan Anda telah diperbarui';

        // Create notification for student
        \App\Models\Notification::create([
            'user_id' => $order->student_id,
            'title' => 'Status Pengantaran Diperbarui',
            'message' => $message,
            'type' => 'delivery_status',
            'data' => [
                'order_code' => $order->order_code,
                'delivery_status' => $status,
                'order_id' => $order->id
            ]
        ]);

        // Send FCM notification if student has token
        if ($order->student->fcm_token) {
            // You can implement FCM sending here
        }
    }
}