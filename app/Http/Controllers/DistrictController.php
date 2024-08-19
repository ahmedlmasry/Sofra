<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Governorate;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = District::paginate(10);
        return view('districts.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        return view('districts.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name'=>'required']);
        $record = District::create($request->all());
        flash()->success('success');
        return redirect()->route('districts.index');
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
        $model = District::findOrfail($id);
        return view('districts.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = District::findOrfail($id);
        $record->update($request->all());
        flash()->success('Edited');
        return redirect()->route('districts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = District::findorfail($id);
        $record->delete();
        flash()->error('Deleted');
        return back();
    }
}
