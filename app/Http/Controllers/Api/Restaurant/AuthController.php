<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\Restaurant;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:restaurants',
            'password' => 'required|confirmed',
            'phone' => 'required|unique:restaurants',
            'district_id' => 'required|exists:districts,id',
            'image' => 'required',
            'status' => 'required|in:0,1',
            'category_id' => 'required|array|exists:categories,id',
            'minimum_order' => 'required',
            'contact_phone' => 'required',
            'contact_whats' => 'required',
            'delivery_charge' => 'required'
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $request->merge(['password' => bcrypt($request->password)]);
        $restaurant = Restaurant::create($request->all());
        $restaurant->categories()->sync($request->category_id);
        $token = $restaurant->createToken('restaurantToken');
        $restaurant->save();
        return responseJson(1, 'successfully created', [
            'restaurant' => $restaurant,
            'token' => $token->plainTextToken
        ]);
    }

    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $restaurant = Restaurant::where('email', $request->email)->first();
        if ($restaurant) {
            if (Hash::check($request->password, $restaurant->password)) {
                $token = $restaurant->createToken('restaurantToken');
                return responseJson(1, 'successfully login',
                    [
                        'restaurant' => $restaurant,
                        'token' => $token->plainTextToken
                    ]);
            } else {
                return responseJson(0, 'wrong password');
            }
        } else {
            return responseJson(0, 'wrong email');
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $restaurant = Restaurant::where('email', $request->email)->first();
        if($restaurant) {
            $code = rand(1111, 9999);
            $update = $restaurant->update(['pin_code' => $code]);
            if ($update) {
                Mail::to($restaurant->email)
                    ->bcc('hello@example.com')
                    ->send(new ResetPassword($restaurant));
                return responseJson(1, 'برجاء فحص هاتفك', ['pin_code' => $code]);
            } else {
                return responseJson(0, 'حدث خطأ حاول مرة اخري');
            }
        }
    }

    public function newPassword(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'pin_code' => 'required',
            'email' => 'required|email',
            'new_password' => 'required|confirmed',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $restaurant = Restaurant::where('pin_code', $request->pin_code)->where('email', $request->email)->first();
        if ($restaurant) {
            $restaurant->update(['password' => bcrypt($request->new_password), 'pin_code' => null]);
            return responseJson(1, 'تم تحديث الباسورد');
        } else {
            return responseJson(0, 'هذا الكود غير صالح');
        }
    }

    public function profile(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'password' => 'confirmed',
            'phone' => Rule::unique('clients')->ignore($request->user()->id),
            'email' => Rule::unique('clients')->ignore($request->user()->id),
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $loginUser = $request->user();
        $request->merge(['password' => bcrypt($request->password)]);
        $loginUser->update($request->all());
        if ($loginUser->save()) {
            return responseJson(1, 'تم تعديل البيانات بنجاح',
                ['restaurant' => $loginUser->with('district.city')->first()]);
        } else {
            return responseJson(0, 'حدث خطأ حاول مرة اخري');
        }

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return responseJson(1, 'تم تسجيل الخروج بنجاح');
    }

    public function registerToken(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'token' => 'required',
            'platform' => 'required|in:android,ios',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        Token::where('token', $request->token)->delete();
        $request->user()->notfTokens()->create($request->all());
        return responseJson(1, 'تم التسجيل بنجاح');
    }

    public function removeToken(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        Token::where('token', $request->token)->delete();
        return responseJson(1, 'تم الحذف بنجاح');
    }


}
