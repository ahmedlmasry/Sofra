<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $meals = $request->user()->meals()->paginate(10);
        return responseJson(1,'success',$meals);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image' => 'required',
            'offer_price' => 'required',
            'meal_time' => 'required',
        ]);
        if($validator->fails()){
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        $meal = $request->user()->meals()->create($request->all());
        return responseJson(1,'success',$meal);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $meal = Meal::find($id);
        $meal->update($request->all());
        return responseJson(1,'updated successfully',$meal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $meal = Meal::find($id);
        $meal->delete();
        return responseJson(1,'deleted successfully');

    }
}
