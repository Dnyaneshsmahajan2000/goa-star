@extends('layouts.app')

@section('content')
@php
    $permissions = Auth::user()->permission;
    $access = unserialize($permissions);
@endphp
<div class="card">
    <div class="card-header p-2 bg-primary ">
        <div class="d-sm-flex align-items-end">
            <h6 class="card-title flex-grow-1"></h6>
            <div class="flex-shrink-0">
                <a class="btn btn-primary btn-sm btn-light" title="Alt + A" id='view-all-button'
                    href="{{ route('item_group.create') }}" class=" btn btn-sm btn-primary text-white">
                    <i class='ri-add-line align-bottom me-1'></i> Add New Item Group</a>
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table id='datatable' class='table table-sm table-bordered   table-hover bg-white'>
                <thead>
                    <tr>
                        <th scope="col">Sr.No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($itemGroups as $itemGroup)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $itemGroup->name }}</td>
                        <td>{{ $itemGroup->description }}</td>
                        <td>
                            <a href="{{ route('item_group.edit', $itemGroup->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('item_group.destroy', $itemGroup->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item group?')">Delete</button>
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
