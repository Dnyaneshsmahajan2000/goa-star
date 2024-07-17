<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     *  @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_roles=UserRole::all();
        return view('user_roles.index', compact('user_roles'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     *  @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        return view('user_roles.create');
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
            'name'=>'required|string|max:50',
        ]);
        try{
            $role=new UserRole();
            $role->name=ucwords($request->name);
            $role->can_login=$request->can_login;
            $role->save();
            return redirect()->route('role.index')->with('success','Inserted Successfully');
        } catch(\Exception $e){
            return redirect()->back()->withInput()->with('error','An unexpected error occurred. Please try again later.' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * 
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserRole $userRole)
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
        $UserRole=UserRole::find($id);
        return view('user_roles.edit',compact('UserRole')) ;
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
        $UserRole=UserRole::find($id);
        $UserRole->name=ucwords($request->name);
        $UserRole->can_login=$request->can_login;
        $UserRole->save();
        return redirect()->route('role.index')->with('success','Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $UserRole=UserRole::find($id);
        $UserRole->delete();
        return redirect()->route('role.index')->with('success','Deleted Successfully');

    }
}
