<?php

namespace App\Observers;

use App\Models\Order;
use App\Events\NewOrderCreated;
use App\Events\OrderStatusUpdated;
use App\Notifications\OrderStatusNotification;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        NewOrderCreated::dispatch($order->id);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Check if either order_status or payment_status has changed.
        if ($order->isDirty('order_status') || $order->isDirty('payment_status')) {
            OrderStatusUpdated::dispatch($order);
        }

        if ($order->isDirty('order_status')) {
            $order->student->notify(new OrderStatusNotification($order));
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
