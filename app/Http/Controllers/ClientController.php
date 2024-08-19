<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = Client::where(function ($query) use ($request) {
            if ($request->search)
            $query->where('name', 'like', '%' . $request->search . '%');
        })->paginate(10);
        return view('clients.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
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
        $record = Client::create($request->all());
        flash()->success('success');
        return redirect()->route('clients.index');
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
        $model = Client::findOrfail($id);
        return view('clients.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = Client::findOrfail($id);
        $record->update($request->all());
        flash()->success('Edited');
        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Client::findorfail($id);
        $record->delete();
        flash()->error('Deleted');
        return back();
    }
    public function search(Request $request)
    {
        $records = Client::where('name', 'LIKE', '%' . $request->search . '%')->get();
        return view('clients.index', compact('records'));
    }
    public function active($id)
    {
        $active =   Client::findorfail($id);
        $active->status = '1';
        $active->save();

        flash()->success('Client Activated Successfully');
        return back();
    }

    public function deactive(Request $request,$id)
    {
        $deactive = Client::findOrFail($id);
        $deactive->status = '0';
        $deactive->save();

        flash()->error('Client De Activated Successfully');
        return back();
    }
}
