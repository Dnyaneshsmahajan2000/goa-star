<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $groups = Group::where('is_enabled', 1)->get();

        return view('groups.index', compact('groups'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $groups = Group::get_all_groups();

        return view('groups.create', compact('groups'));
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
            'group_name' => 'required|string|max:255',
            'parent_id' => 'required|integer',
        ]);

        // Retrieve the parent group's level from the database
        $parentGroup = Group::findOrFail($request->parent_id);
        $parentLevel = $parentGroup->level;

        // Create a new group instance
        $group = new Group();
        $group->group_name = ucwords($request->group_name);
        $group->parent_id = $request->parent_id;
        $group->level = $parentLevel + 1;

        // Save the group to the database
        $group->save();

        // Redirect to the index page with a success message
        return redirect()->route('group.index')->with('success', 'Group created successfully');
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
        //return $this->destroy($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::find($id);
        $groups = Group::get_all_groups();
        return view('groups.edit', compact('groups', 'group'));
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
        $group = Group::find($id);
        $group->group_name = ucwords($request->group_name);
        $group->parent_id = $request->parent_id;

        $parentGroup = Group::findOrFail($request->parent_id);
        $parentLevel = $parentGroup->level;
        $group->level = $parentLevel + 1;
        $group->save();
        return redirect()->route('group.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //return 'delete';
        $group = Group::find($id);
        $group->delete();
        return redirect()->route('group.index')->with("success", "Deleted Successfully");
    }
}
