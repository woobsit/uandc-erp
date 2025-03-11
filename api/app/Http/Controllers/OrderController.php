<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderHistory;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;


class OrderController extends Controller
{
    public function showOrders(Request $request)
    {
        try {
            $results = $request->input('results', 10);
            $page = $request->input('page', 1); // Get current page
            $cacheKey = "orders_page_{$page}_results_{$results}";

            // Check if the data is cached
            $order = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($results) {
                return Order::select([
                    'id',
                    'fullname',
                    'customer_phone',
                    'pickup_time',
                    'pickup_address',
                    'delivery_address',
                    'delivery_type',
                    'status',
                    'payment_status',
                    'total_cost',
                    'discount',
                    'delivery_time_slot',
                    'distance',
                    'estimated_delivery_time',
                    'actual_delivery_time',
                    'created_at'
                ])
                    ->orderBy('created_at', 'desc')
                    ->paginate($results);
            });

            if ($order->isEmpty()) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No records found',
                ]);
            }

            return response()->json([
                'status' => 201,
                'message' => 'success',
                'result' => $order->items(),
                'pagination' => [
                    'total' => $order->total(),
                    'per_page' => $order->perPage(),
                    'current_page' => $order->currentPage(),
                    'last_page' => $order->lastPage(),
                    'from' => $order->firstItem(),
                    'to' => $order->lastItem(),
                ],
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => 500, 'message' => 'System error occurred']);
        }
    }

    public function createOrders(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|min:3|max:30',
                'pickup_address' => 'required|max:1000',
                'delivery_address' => 'required|max:1000',
                'item_description' => 'required|max:1000',
                'status' => 'required|in:Pending,Processing,Completed,Cancelled',
                'customer_phone' => ['required', 'regex:/^0[0-9]{10}$/'],
                'customer_email' => 'nullable',
                'delivery_type' => 'required',
                'delivery_time_slot' => 'nullable',
                'distance' => 'nullable',
                'estimated_delivery_time' => 'nullable',
                'actual_delivery_time' => 'nullable',
                'package_weight' => 'nullable',
                'package_dimensions' => 'nullable',
                'is_fragile' => 'nullable',
                'special_instructions' => 'nullable',
                'payment_status' => 'required',
                'payment_method' => 'required',
                'total_cost' => 'required',
                'discount' => 'nullable',
                'rider_id' => 'required',
                'rider_notes' => 'nullable',
                'pickup_time' => 'nullable',
                'delivery_attempts' => 'nullable',
                'failed_delivery_reason' => 'nullable',
                'order_source' => 'nullable',
                'order_priority' => 'nullable',
                'cancellation_reason' => 'nullable',
                'scheduled_pickup_time' => 'nullable',
                'scheduled_delivery_time' => 'nullable',
                'cancelled_at' => 'nullable',
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->messages()->all(),
                ]);
            }

            $order = Order::create([
                'full_name' => $request->input('full_name'),
                'pickup_address' => $request->input('pickup_address'),
                'delivery_address' => $request->input('delivery_address'),
                'item_description' => $request->input('item_description'),
                'status' => $request->input('status'),
                'customer_phone' => $request->input('customer_phone'),
                'customer_email' => $request->input('customer_email'),
                'delivery_type' => $request->input('delivery_type'),
                'delivery_time_slot' => $request->input('delivery_time_slot'),
                'distance' => $request->input('distance'),
                'estimated_delivery_time' => $request->input('estimated_delivery_time'),
                'actual_delivery_time' => $request->input('actual_delivery_time'),
                'package_weight' => $request->input('package_weight'),
                'package_weight' => $request->input('package_weight'),
                'package_dimensions' => $request->input('package_dimensions'),
                'is_fragile' => $request->input('is_fragile'),
                'special_instructions' => $request->input('special_instructions'),
                'payment_status' => $request->input('payment_status'),
                'payment_method' => $request->input('payment_method'),
                'total_cost' => $request->input('total_cost'),
                'discount' => $request->input('discount'),
                'rider_id' => $request->input('rider_id'),
                'rider_notes' => $request->input('rider_notes'),
                'pickup_time' => $request->input('pickup_time'),
                'delivery_attempts' => $request->input('delivery_attempts'),
                'failed_delivery_reason' => $request->input('failed_delivery_reason'),
                'order_source' => $request->input('order_source'),
                'order_priority' => $request->input('order_priority'),
                'cancellation_reason' => $request->input('cancellation_reason'),
                'scheduled_pickup_time' => $request->input('scheduled_pickup_time'),
                'scheduled_delivery_time' => $request->input('scheduled_delivery_time'),
                'cancelled_at' => $request->input('cancelled_at'),

            ]);

            OrderHistory::create([
                'order_id'   => $order->id,
                'action'     => 'created',
                'data'       => json_encode($order->toArray()),
                'changed_by' => auth()->id(), // if available; otherwise null
            ]);

            return response()->json([
                'status' => 201,
                'message' => 'Order was successful'
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => 500, 'message' => 'System error occured']);
        }
    }
}
