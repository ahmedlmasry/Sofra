<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $offer = $request->user()->offers()->paginate(10);
        return responseJson(1,'success',$offer);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'name' => 'required',
            'details' => 'required',
            'image' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required',

        ]);
        if($validator->fails()){
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        $offer = $request->user()->offers()->create($request->all());
        return responseJson(1,'success',$offer);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
        $offer = Offer::find($id);
        $offer->update($request->all());
        return responseJson(1,'updated successfully',$offer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $offer = Offer::find($id);
        $offer->delete();
        return responseJson(1,'deleted successfully');

    }
}
