<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Setting::all();
            return view('settings.index', compact('records'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = Setting::findOrfail($id);
        return view('settings.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = Setting::findOrfail($id);
        $record->update([
            'commission' => $request->commission,
            'google_play_link' => $request->google_play_link,
            'app_store_link' => $request->app_store_link
        ]);
        flash()->success('Edited');
        return redirect()->route('settings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }

}
