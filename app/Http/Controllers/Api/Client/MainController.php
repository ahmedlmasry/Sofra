<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Meal;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Token;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function newOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'meals.*.meal_id' => 'required|exists:meals,id',
            'meals.*.quantity' => 'required|integer|min:1',
            'address' => 'required',
            'payment_method' => 'required|in:cash,visa',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $restaurant = Restaurant::find($request->restaurant_id);
        if ($restaurant->status == '0') {
            return responseJson(0, 'عذرا المطعم غير متاح في الوقت الحالي');
        }
        $order = $request->user()->orders()->create([
            'restaurant_id' => $restaurant->id,
            'note' => $request->note,
            'state' => 'pending',
            'address' => $request->address,
            'payment_method' => $request->payment_method
        ]);
        $cost = 0;
        $deliveryCost = $restaurant->delivery_charge;
        foreach ($request->meals as $i) {
            $meal = Meal::find($i['meal_id']);
            $readyMeal = [
                $i['meal_id'] => [
                    'quantity' => $i['quantity'],
                    'price' => $meal->price,
                    'special_note' => $meal->note,
                ]
            ];
            $order->meals()->attach($readyMeal);
            $cost = ($meal->offer_price * $i['quantity']);
        }
        if ($cost >= $restaurant->minimum_order) {
            $total = $cost + $deliveryCost;
            $commission = settings()->commission * $cost / 100;
            $update = $order->update([
                'total_price' => $total,
                'delivery_charge' => $deliveryCost,
                'commission' => $commission
            ]);
            $orderData = [
                'order' => $order->fresh()->load('meals')
            ];
            $notification =$restaurant->notifications()->create([
                'title' => 'لديك طلب جديد ',
                'content' => $request->user()->name . ' لديك طلب جديد من العميل'
            ]);
            $tokens = $restaurant->notfTokens()->where('token', '!=', '')->pluck('token')->toArray();
            if (count($tokens)) {
                $title = $notification->title;
                $body = $notification->content;
                $data = [
                    'order_id' => $order->id,
                    'user_type' => 'restaurant',
                    'action' => 'new-order',
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);
            }
            return responseJson(1, 'تم الطلب بنجاح', compact('orderData','send'));
        } else {
            $order->meals()->delete();
            $order->delete();
            return responseJson(0, 'الطلب لابد ان لا يكون' . $restaurant->minimum_order . 'ريال');
        }
    }

    public function currentOrders(Request $request)
    {
        $orders = $request->user()->orders()
            ->where('state', 'pending')
            ->orwhere('state', 'accepted')
            ->with('restaurant')->paginate(10);
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
            ->with('restaurant')->paginate(10);
        if ($orders->count()) {
            return responseJson(1, 'success', $orders);
        } else {
            return responseJson(0, 'no orders');
        }
    }

    public function receiveOrders(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $order = $request->user()->orders()->where('id', $request->order_id)
            ->where('state', 'pending')->orwhere('state', 'accepted')->first();
        if ($order) {
            $order->update(['state' => 'delivered']);
            return responseJson(1, 'success', $order);
        } else {
            return responseJson(0, 'selected order is delivered');
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
            ->where('state', 'pending')->orwhere('state', 'accepted')->first();
        if ($order) {
            $order->update(['state' => 'rejected']);
            return responseJson(1, 'success', $order);
        } else {
            return responseJson(0, 'selected order is delivered');
        }
    }

    public function addComments(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'body' => 'required|string',
            'rating' => 'required|integer|in:1,2,3,4,5',

        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $comment = $request->user()->comments()->create($request->all());
        return responseJson(1, 'success', $comment);
    }

}
