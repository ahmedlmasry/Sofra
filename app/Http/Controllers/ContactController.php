<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = Contact::where(function ($query) use ($request) {
            if($request->search) {
                $query->where('name' , 'like' , '%' . $request->search . '%');
            }
        })->paginate(10);
        return view('contacts.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
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
        $model = Contact::findOrfail($id);
        return view('contacts.edit', compact('model'));
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
        $record = Contact::findorfail($id);
        $record->delete();
        flash()->error('Deleted');
        return back();
    }
    public function search(Request $request)
    {
        $records = Contact::where('name', 'LIKE', '%' . $request->search . '%')->get();
        return view('contacts.index', compact('records'));
    }
}
