@extends('layouts.app',['title'=>'Update User Role'])
@section('content')

    <div class='row'>
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"></h4>
                        <div class="page-title-right">
                            
                                    <a title="Alt + A" id='view-all-button' href='{{@route('role.index')}}' class=" btn btn-sm btn-primary text-white">
                                        View All User Roles
                                    </a>

                                
                        </div>


                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('role.update', $UserRole->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf <!-- CSRF token for security -->
                        @method('PUT') <!-- Method spoofing for PUT request -->

                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="name" class="form-label">Name<span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Name" required class="form-control" id="name" name="name" value="{{ $UserRole->name }}">
                                    </div>
                                    
                                </div>

                                

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="opening_bal_type" class="form-label">Can Login</label>
                                        <select name="can_login" id="can_login" class="form-select">
                                            <option value="1" {{ $UserRole->can_login == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ $UserRole->can_login == '0' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                    
                                </div>

                                <!-- Add input fields for the remaining columns -->

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary mt-4" name="submit">Update User Role</button>
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
