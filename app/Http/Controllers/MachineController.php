<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function __construct()
    {
      //  $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $machines = Machine::all();

        return view('Machine.index', compact('machines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Machine = Machine::all();

        return view('Machine.create', compact('Machine'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',

        ]);
        try {
            $machin = new Machine();
            $machin->name = ucwords($request->name);
            $machin->details = $request->details;
            $machin->save();
            return redirect()->route('Machine.index')->with("success", 'Inserted Successfully');
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return redirect()->back()->withInput()->with('error' , 'An unexpected error occurred. Please try again later.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
        $machine=Machine::find($id);
        return view('Machine.edit', ['machine' => $machine]);
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
        $machine=Machine::find($id);
        $machine->name=ucwords($request->name);
        $machine->details=$request->details;
        $machine->save();
        return redirect()->route('Machine.index')->with("success",'Updated Sucessfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $machine = Machine::find($id);
        $machine->delete();
        return redirect()->route('Machine.index')->with("success", 'deleted successfully');
    }
}
