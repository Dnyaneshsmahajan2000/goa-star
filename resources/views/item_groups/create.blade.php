@extends('layouts.app', ['title' => 'Add New Item Group'])
@section('content')
    <div class='row'>
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-header p-2 bg-primary ">
                    <div class="d-sm-flex align-items-end">
                        <h6 class="card-title flex-grow-1"></h6>
                        <div class="flex-shrink-0">
                            <a class="btn btn-primary btn-sm btn-light" title="Alt + A" id='view-all-button'
                                href="{{ route('item_group.index') }}" class=" btn btn-sm btn-primary text-white">
                                View All Item Groups
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('item_group.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="name" class="form-label">Group Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter group name" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="description" class="form-label">Description</label>
                                        <input class="form-control" id="description" name="description" placeholder="Enter description">
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-3 col-md-3 ">
                                    <div>
                                        <button type="submit" class="btn btn-primary mt-4 " value="submit" name="submit">Add Item Group</button>
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