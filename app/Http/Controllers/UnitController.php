<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;


class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::all();
        return view('units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = new Unit();
        return view('units.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'unit_name' => 'required|string|max:50',

        ]);
        try {
            $units = new Unit();
            $units->unit_name = ucwords($request->unit_name);
            $units->save();
            return redirect()->route('units.index')->with("success", 'Inserted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $units = Unit::find($id);
        return view('units.edit', ['units' => $units]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $units = Unit::find($id);
        $units->unit_name = ucwords($request->unit_name);
        $units->save();
        return redirect()->route('units.index')->with("success", 'Updated Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $units = Unit::find($id);
        $units->delete();
        return redirect()->route('units.index')->with("success", 'deleted successfully');
    }
}
