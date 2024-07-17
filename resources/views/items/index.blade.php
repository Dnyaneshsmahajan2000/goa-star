@extends('layouts.app', ['title' => 'Items'])

@section('content')

@php
    $permissions = Auth::user()->permission;
    $access = unserialize($permissions);
@endphp
<div class="row">
    <div class='col-lg-12'>
        <div class="card">
            <div class="card-header p-2 bg-primary ">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h6 class="mb-sm-0 text-white">Add New Employee</h6>
                    <div class="page-title-right">
                        <a title="Alt + A" id='view-all-button' href='{{ @route('item.create') }}'
                            class=" btn btn-sm btn-light">
                            <i class="ri-add-line "></i>
                            Add New Item
                        </a>
                    </div>
                </div>
            </div>


            <div class="card-body">
                <div class='table-responsive'>
            <table class="table table-striped " id='datatable'>
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        {{-- <th>Description</th> --}}
                        <th>Group Name</th>
                        <th>Item Category</th>
                        {{-- <th>Is BOM</th> --}}
                        <th>Type</th>
                        <th>Unit</th>
                        <th>Weight</th>
                        <th>Rate</th>
                        {{-- <th>GST Rate</th> --}}
                        {{-- <th>HSN Code</th> --}}
                        <th>Opening Stk</th>
                        <th>Min Stk Qty</th>
                        {{-- <th>Main-Stock</th> --}}
                        {{-- <th>Barcode</th> --}}
                        {{-- <th>Discount</th> --}}
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        {{-- <td>{{ $item->description }}</td> --}}
                        <td>{{ $item->itemgroups->name }}</td>
                        <td>{{ $item->itemcategory->name }}</td>
                        {{-- <td>{{ $item->is_bom }}</td> --}}
                        {{-- <td>{{ $item->description }}</td> --}}
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->weight }}</td>
                        <td>{{ $item->rate }}</td>
                        {{-- <td>{{ $item->gst_rate }}</td> --}}
                        {{-- <td>{{ $item->hsn_code }}</td> --}}
                        <td>{{ $item->opening_stock }}</td>
                        <td>{{ $item->min_stock_qty }}</td>
                        {{-- <td>{{ $item->maintain_stock }}</td> --}}
                        {{-- <td>{{ $item->item_barcode }}</td> --}}
                        {{-- <td>{{ $item->discount }}</td> --}}
                        <td>
                            @if ($item->is_bom == 'yes')
                            <a href="{{ route('item.bom.create', $item->id) }}" class="btn btn-sm btn-success">BOM</a>

                            @endif

                            <a href="{{ route('item.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="{{ route('item.show', $item->id) }}" class="btn btn-sm btn-secondary">Show</a>
                            <form action="{{ route('item.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>

                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
