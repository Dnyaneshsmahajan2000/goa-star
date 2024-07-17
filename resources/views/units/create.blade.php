@extends('layouts.app', ['title' => 'Add New Unit'])
@section('content')
    <div class='row'>
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('item.unit.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="name" class="form-label">Unit Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="unit_name" name="unit_name" value="{{ old('unit_name') }}"
                                            placeholder="Enter Unit name" required>
                                        @error('unit_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="description" class="form-label">Description</label>
                                        <input class="form-control" id="description" name="description" placeholder="Enter description">
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="col-xxl-3 col-md-3 ">
                                    <div>
                                        <button type="submit" class="btn btn-primary mt-4 " value="submit" name="submit">Add Item</button>
                                    </div>
                                </div>

                            </div>
                            <!--end row-->
                        </div>
                    </form>

            </div>
        </div><!-- end card -->
    </div>
</div>


@stop