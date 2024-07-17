<?php

namespace App\Http\Controllers;

use App\Models\ItemGroup;
use Illuminate\Http\Request;

class ItemGroupController extends Controller
{
    public function index()
    {
        $itemGroups = ItemGroup::all();
        return view('item_groups.index', compact('itemGroups'));
    }

    public function create()
    {
        return view('item_groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255', // Updated validation for description
        ]);
    
        $requestData = $request->all();
        $requestData['name'] = ucwords($requestData['name']);
    
        ItemGroup::create($requestData);
    
        return redirect()->route('item_group.index')->with('success', 'Item group created successfully.');
    }
    

    public function edit($id)
    {
        $ItemGroup = ItemGroup::find($id);

        return view('item_groups.edit', compact('ItemGroup'));
    }

    public function update(Request $request, $id)
    {

        $ItemGroup = ItemGroup::find($id);

        $ItemGroup->name = ucwords($request->name);
        $ItemGroup->description = $request->description;
        $ItemGroup->save();

        return redirect()->route('item_group.index')->with('success', 'Item group updated successfully.');
    }


    public function destroy($id)
    {

        $ItemGroup = ItemGroup::find($id);
        $ItemGroup->delete($ItemGroup);

        return redirect()->route('item_group.index')->with('success', 'Item group deleted successfully.');
    }
}
