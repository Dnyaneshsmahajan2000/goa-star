<?php

namespace App\Http\Controllers;

use App\Models\Godown;
use Illuminate\Http\Request;

class GodownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $godowns =godown::all();
        return view('godown.index',compact('godowns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $Godown = godown::all();
        return view('godown.create', compact('Godown'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:50',
            'mobile_no' => 'required|string|max:15',
            'address' => 'required|string', // Assuming 'text' was a typo and you meant 'string'
        ]);
    
        try {
            // Assuming you have an Eloquent model for your database table
            $godown = new godown(); // Assuming your model is named 'Godown'
            $godown->name = ucwords($request->name);
            $godown->mobile_no = $request->mobile_no;
            $godown->address = $request->address;
            $godown->save();
    
            // If you want to return a response after successful insertion
            return redirect()->route('godown.index')->with("success", 'Inserted Successfully');
            // return response()->json(['message' => 'Godown created successfully'], 201);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the process
            // return response()->json(['message' => 'Failed to create godown', 'error' => $e->getMessage()], 500);
            return redirect()->back()->withInput()->with('error' , 'An unexpected error occurred. Please try again later.');
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Godown  $godown
     * @return \Illuminate\Http\Response
     */
    public function show(Godown $godown)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $godown=Godown::find($id);
        return view('godown.edit',['godown'=>$godown]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $godown=Godown::find($id);
        $godown->name=ucwords($request->name);
        $godown->mobile_no=$request->mobile_no;
        $godown->address=$request->address;
        $godown->save();
        return redirect()->route('godown.index')->with("success",'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $godown=Godown::find($id);
        $godown->delete();
        return redirect()->route('godown.index')->with("success",'Deleted Successfully');

    }
}
