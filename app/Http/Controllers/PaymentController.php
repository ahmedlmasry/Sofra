<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Payment;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = Payment::where(function ($query) use($request){
            if ($request->search){
                $query->whereHas('restaurant', function ($query) use($request){
                    $query->where('name','like', '%'.$request->search.'%');
                });
            }
        })->paginate(10);
        return view('payments.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $restaurants = Restaurant::all();
        return view('payments.create', compact('restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required',
            'note' => 'required',
            'paid' => 'required'
        ]);
        $record = Payment::create([
            'restaurant_id' => $request->restaurant_id,
            'note' => $request->note,
            'paid' => $request->paid
        ]);
        flash()->success('success');
        return redirect()->route('payments.index');
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
        $model = Payment::findOrfail($id);
        $restaurants = Restaurant::all();
        return view('payments.edit', compact('model', 'restaurants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = Payment::findOrfail($id);
        $record->update([
            'name' => $request->name,
            'note' => $request->note,
            'paid' => $request->paid
        ]);
        flash()->success('Edited');
        return redirect()->route('payments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Payment::findorfail($id);
        $record->delete();
        flash()->error('Deleted');
        return back();
    }

}
