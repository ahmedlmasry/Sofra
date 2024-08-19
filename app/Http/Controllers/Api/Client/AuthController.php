<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\Client;
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
            'email' => 'required|email|unique:clients',
            'password' => 'required|confirmed',
            'phone' => 'required|unique:clients',
            'district_id' => 'required|exists:districts,id',
            'image' => 'required',
            'status' => 'required|in:0,1',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $token = $client->createToken('clientToken');
        $client->save();
        return responseJson(1, 'successfully created', [
            'client' => $client, 'token' => $token->plainTextToken
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
        $client = Client::where('email', $request->email)->first();
        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                $token = $client->createToken('clientToken');
                return responseJson(1, 'successfully login', [
                    'client' => $client, 'api_token' => $token->plainTextToken]);
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
        $client = Client::where('email', $request->email)->first();
        if($client){
            $code = rand(1111, 9999);
            $update = $client->update(['pin_code' => $code]);
            if ($update) {
                Mail::to($client->email)
                    ->bcc('hello@example.com')
                    ->send(new ResetPassword($client));
                return responseJson(1, 'برجاء فحص هاتفك', ['pin_code' => $code]);
            } else {
                return responseJson(0, 'حدث خطأ حاول مرة اخري');
            }
        }
    }
    public function newPassword(Request $request){
        $validator = validator()->make($request->all(), [
            'pin_code' => 'required',
            'email' => 'required|email',
            'new_password' => 'required|confirmed',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $client = Client::where('pin_code',$request->pin_code)->where('email',$request->email)->first();
        if($client){
            $client->update(['password' => bcrypt($request->new_password),'pin_code' => null]);
            return responseJson(1,'تم تحديث الباسورد');
        }
        else{
            return responseJson(0,'هذا الكود غير صالح');
        }
    }
    public function profile(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'password'=>'confirmed',
            'phone'=> Rule::unique('clients')->ignore($request->user()->id),
            'email'=> Rule::unique('clients')->ignore($request->user()->id),
        ]);
        if($validator->fails()){
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        $loginUser= $request->user();
        $request->merge(['password'=>bcrypt($request->password)]);
        $loginUser->update($request->all());
        if($loginUser->save()){
            return responseJson(1,'تم تعديل البيانات بنجاح',['client'=>$loginUser]);
        }else{
            return responseJson(0,'حدث خطأ حاول مرة اخري');
        }

    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return responseJson(1,'تم تسجيل الخروج بنجاح');
    }


}
