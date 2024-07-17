<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ItemCategory = ItemCategory::all();
        return view('item_categories.index', compact('ItemCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ItemCategory = ItemCategory::all();
        return view('item_categories.create', compact('ItemCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $itemCategory = new ItemCategory();
        $itemCategory->name = ucwords($validatedData['name']);
        $itemCategory->description = $request['description'];

        $itemCategory->save();

        return redirect()->route('item.category.index')->with('success', 'Item category created successfully.');
    }

    public function show(string $id)
    {
        $ItemCategory = ItemCategory::find($id);

        return view('item_categories.show', compact('ItemCategory'));
    }

    public function edit($id)
    {
        $ItemCategory = ItemCategory::find($id);

        return view('item_categories.edit', compact('ItemCategory'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $itemCategory = ItemCategory::find($id);

        $itemCategory->name = ucwords($validatedData['name']);
        $itemCategory->description = $request['description'];

        $itemCategory->save();

        return redirect()->route('item.category.index')->with('success', 'Item category updated successfully.');
    }


    public function destroy(string $id)
    {
        $group= ItemCategory::find($id);
        $group->delete();
        return redirect()->route('item.category.index')->with("success","Deleted Successfully");
    }
}
