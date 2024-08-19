<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function newsOrders(Request $request)
    {
        $orders = $request->user()->orders()->where('state', 'pending')->with('client')->paginate(10);
        if ($orders->count()) {
            return responseJson(1, 'success', $orders);
        } else {
            return responseJson(0, 'no orders');
        }
    }

    public function currentOrders(Request $request)
    {
        $orders = $request->user()->orders()->where('state', 'accepted')->with('client')->paginate(10);
        if ($orders->count()) {
            return responseJson(1, 'success', $orders);
        } else {
            return responseJson(0, 'no orders');
        }
    }

    public function previousOrders(Request $request)
    {
        $orders = $request->user()->orders()->where('state', 'declined')
            ->orwhere('state', 'rejected')
            ->orwhere('state', 'delivered')
            ->with('client')->paginate(10);
        if ($orders->count()) {
            return responseJson(1, 'success', $orders);
        } else {
            return responseJson(0, 'no orders');
        }
    }

    public function acceptOrders(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $order = $request->user()->orders()->where('id', $request->order_id)
            ->where('state', 'pending')->first();
        if ($order) {
            $order->update(['state' => 'accepted']);
            $client = Client::find($order->client->id);
            $notification = $client->notifications()->create([
                'title' => ' تم قبول الطلب  ',
                'content' => $request->user()->name . ' تم قبول طلبك من مطعم'
            ]);
            $tokens = $request->user()->notfTokens()->where('token', '!=', '')->pluck('token')->toArray();
            if (count($tokens)) {
                $title = $notification->title;
                $body = $notification->content;
                $data = [
                    'order_id' => $order->id,
                    'user_type' => 'restaurant',
                    'action' => 'accept-order',
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);
            }
            return responseJson(1, 'success', compact('order', 'send'));
        } else {
            return responseJson(0, 'selected order is not pending ');
        }
    }

    public function cancelOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $order = $request->user()->orders()->where('id', $request->order_id)
            ->where('state', 'pending')->first();
        if ($order) {
            $order->update(['state' => 'rejected']);
            $client = Client::find($order->client->id);
            $notification = $client->notifications()->create([
                'title' => ' تم رفض الطلب  ',
                'content' => $request->user()->name . ' تم رفض طلبك من مطعم'
            ]);
            $tokens = $request->user()->notfTokens()->where('token', '!=', '')->pluck('token')->toArray();
            if (count($tokens)) {
                $title = $notification->title;
                $body = $notification->content;
                $data = [
                    'order_id' => $order->id,
                    'user_type' => 'restaurant',
                    'action' => 'accept-order',
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);
            }
            return responseJson(1, 'success', compact('order', 'send'));
        } else {
            return responseJson(0, 'selected order is not pending');
        }
    }

    public function deliverOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $order = $request->user()->orders()->where('id', $request->order_id)
            ->where('state', 'accepted')->first();
        if ($order) {
            $order->update(['state' => 'delivered']);
            return responseJson(1, 'success', $order);
        } else {
            return responseJson(0, 'selected order is rejected');
        }
    }

    public function payments(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'paid' => 'required|numeric|min:0',
            'note' => 'required|string'
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $payments = $request->user()->payments()->create($request->all());
        return responseJson(1, 'success', $payments);
    }

    public function commissions(Request $request)
    {
        $commissions = $request->user()->orders()->where('state', 'delivered')->sum('commission');
        $sales = $request->user()->orders()->where('state', 'delivered')->sum('total_price');
        $paid = $request->user()->payments()->sum('paid');
        $remaining = $commissions - $paid;
        return responseJson(1, 'success', [
            'sales' => $sales,
            'commissions' => $commissions,
            'paid' => $paid,
            'remaining' => $remaining,
        ]);
    }
}
