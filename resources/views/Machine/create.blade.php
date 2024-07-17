@extends('layouts.app',['title'=>'Add New Machine'])
@section('content')

<div class='row'>
    <div class='col-lg-12'>
        <div class="card">
            <div class="card-header p-2 bg-primary ">
                <div class="d-sm-flex align-items-end">
                    <h6 class="card-title flex-grow-1"></h6>
                    <div class="flex-shrink-0">
                        <a class="btn btn-primary btn-sm btn-light" title="Alt + A" id='view-all-button'
                            href="{{ route('machine.index') }}" class=" btn btn-sm btn-primary text-white">
                            View All Machine
                        </a>
    
                    </div>
                </div>
            </div>
            <div class="card-body">
               
            <form action="{{ route('machine.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf <!-- CSRF token for security -->

                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="placeholderInput" class="form-label">Machine Name<span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Name" required class="form-control form-control" id="name" name="name" value="{{ old('name') }}" style="text-transform:capitalize">
                                    </div>
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                           
                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="placeholderInput" class="form-label">Details<span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Details" required class="form-control form-control" id="details" name="details" value="{{ old('details') }}" style="text-transform:capitalize">
                                    </div>
                                    @error('details')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                           

                                <div class="col-xxl-3 col-md-3 ">
                                    <div>
                                        <button type="submit" class="btn btn-primary mt-4 " value="submit" name="submit">Add Machine</button>
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