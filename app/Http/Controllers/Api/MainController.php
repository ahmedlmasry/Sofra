<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\District;
use App\Models\Meal;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function categories()
    {
        $categories = Category::paginate(10);
        return responseJson(1, 'success', $categories);
    }

    public function cities()
    {
        $cities = City::paginate(10);
        return responseJson(1, 'success', $cities);
    }

    public function districts(Request $request)
    {
        $districts = District::where(function ($query) use ($request) {
            if ($request->has('city_id')) {
                $query->where('city_id', $request->city_id);
            }

        })->get();
        return responseJson(1, 'success', $districts);
    }

    public function contacts()
    {
        $contacts = Contact::paginate(10);
        return responseJson(1, 'success', $contacts);
    }

    public function restaurants(Request $request)
    {
        $restaurants = Restaurant::where(
            function ($query) use ($request) {
                if ($request->has('city_id')) {
                    $query->wherehas('district', function ($query) use ($request) {
                        $query->where('city_id', $request->city_id);
                    });
                }
            }
        )->with('district.city')->paginate(10);
        return responseJson(1, 'success', $restaurants);
    }

    public function meals(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $meals = Meal::where('restaurant_id', $request->restaurant_id)->paginate(10);
        if ($meals->count()) {
            return responseJson(1, 'success', $meals);
        } else {
            return responseJson(0, 'no meals');
        }

    }

    public function comments(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $comment = Comment::where('restaurant_id', $request->restaurant_id)->with('client')->paginate(8);
        if ($comment) {
            return responseJson(1, 'success', $comment);
        } else {
            return responseJson(0, 'no comments');
        }
    }

    public function restaurantInfo(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $comment = Restaurant::where('id', $request->restaurant_id)->with('district')->paginate(10);
        if ($comment) {
            return responseJson(1, 'success', $comment);
        } else {
            return responseJson(0, 'no restaurants');
        }
    }

    public function mealDetails(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'meal_id' => 'required|exists:meals,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $meal = Meal::where('id', $request->meal_id)->paginate(10);
        if ($meal) {
            return responseJson(1, 'success', $meal);
        } else {
            return responseJson(0, 'no meals');
        }
    }

    public function offers()
    {
        $offers = Offer::where('start_date', '<=', now())->where('end_date', '>=', now())->paginate(8);
        return responseJson(1, 'success', $offers);
    }
}
