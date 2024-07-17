@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Edit Unit</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('item.unit.update',[$units->id] ) }}" method="POST" class="needs-validation" novalidate>
        
        {{-- <form action="{{ route('item_group.update',[$units->id]) }}" method="POST" class="needs-validation" novalidate>
         --}}    @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Unit Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="unit_name" name="unit_name" value="{{ $units->unit_name }}" required>
                @error('unit_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description">{{ $units->description }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div> --}}

            <button type="submit" class="btn btn-primary">Update Unit</button>
        </form>
    </div>
</div>
@endsection
