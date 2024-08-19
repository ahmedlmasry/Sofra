<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Restaurant::paginate(10);
        return view('restaurants.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
        ]);
//        dd('dsf');
        $record = Restaurant::create($request->all());
        flash()->success('success');
        return redirect()->route('restaurants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = Restaurant::findOrfail($id);
        return view('restaurants.show', compact('record'));
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
        $record = Restaurant::findOrfail($id);
        $record->update($request->all());
        flash()->success('Edited');
        return redirect()->route('restaurants.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Restaurant::findorfail($id);
        $record->delete();
        flash()->error('Deleted');
        return back();
    }
    public function search(Request $request)
    {
        $records = Restaurant::where('name', 'LIKE', '%' . $request->search . '%')->get();
        return view('restaurants.index', compact('records'));
    }
    public function active($id)
    {
        $active =   Restaurant::findorfail($id);
        $active->status = '1';
        $active->save();

        flash()->success('Restaurant Activated Successfully');
        return back();
    }

    public function deactive(Request $request,$id)
    {
        $deactive = Restaurant::findOrFail($id);
        $deactive->status = '0';
        $deactive->save();

        flash()->error('Restaurant De Activated Successfully');
        return back();
    }
}
