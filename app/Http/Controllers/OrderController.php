<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        $records = Order::where(function ($query) use ($request) {
            if ($request->search) {
                $query->wherehas('restaurant', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
                });
            } })->paginate(10);
        return view('orders.index', compact('records'));
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

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = Order::findorfail($id);
        return view('orders.show', compact('record'));
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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Order::findorfail($id);
        $record->delete();
        flash()->error('Deleted');
        return back();
    }

    }
