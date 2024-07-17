@extends('layouts.app')

@section('content')
@php
    $permissions = Auth::user()->permission;
    $access = unserialize($permissions);
@endphp
<div class="card">
    <div class="card-header">
        <div class='d-sm-flex align-items-center justify-content-between'>
        <h4 class="mb-0">Units List</h4>
        <div class='page-title-right'>
            <a title='Alt + A' id='view-all-button' href='{{ @route('item.unit.create')}}' class=' btn btn-sm btn-primary text-white'>
            <i class='ri-add-line align-bottom me-1'></i> Add New Unit</a>

        </div>
    </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Unit Name</th>
                        {{-- <th scope="col">Description</th> --}}
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $unit)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $unit->unit_name }}</td>
                        {{-- <td>{{ $unit->description }}</td> --}}
                        <td>
                            <a href="{{ route('item.unit.edit', $unit->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('item.unit.destroy', $unit->id) }}" method="POST" style="display: inline;">
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
