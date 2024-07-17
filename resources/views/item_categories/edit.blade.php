@extends('layouts.app', ['title' => 'Update Item Category'])
@section('content')


    <div class="card">
        <div class="card-header p-2 bg-primary ">
            <div class="d-sm-flex align-items-end">
                <h6 class="card-title flex-grow-1"></h6>
                <div class="flex-shrink-0">
                    <a class="btn btn-primary btn-sm btn-light" title="Alt + A" id='view-all-button'
                        href="{{ route('item.category.index') }}" class=" btn btn-sm btn-primary text-white">
                        View All Item Category</a>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('item.category.update', [$ItemCategory->id]) }}" method="POST" class="needs-validation"
                novalidate>
                @csrf <!-- CSRF token for security -->
                @method('PUT') <!-- Use PUT method for update -->
                <div class="live-preview">
                    <div class="row gy-4">

                        <div class="col-xxl-4 col-md-3">
                            <div>
                                <label for="placeholderInput" class="form-label">Name<span
                                        class="text-danger font-weight-bold">*</span></label>
                                <input type="text" autofocus placeholder="Name" required
                                    class="form-control form-control" id="name" name="name"
                                    value="{{ $ItemCategory['name'] }}" style="text-transform:capitalize">
                            </div>

                        </div>

                        <div class="col-xxl-4 col-md-3">
                            <div>
                                <label for="placeholderInput" class="form-label">Description<span
                                        class="text-danger font-weight-bold">*</span></label>
                                <input type="text" autofocus placeholder="description" required
                                    class="form-control form-control" id="description" name="description"
                                    value="{{ $ItemCategory['description'] }}" style="text-transform:capitalize">
                            </div>

                        </div>


                        <div class="col-xxl-3 col-md-3 ">
                            <div>
                                <button type="submit" class="btn btn-primary mt-4 " value="submit" name="submit">Update
                                    Item</button>
                            </div>
                        </div>

                    </div>
                    <!--end row-->
                </div>
            </form>

        </div>

    </div>
    </div>

@stop
