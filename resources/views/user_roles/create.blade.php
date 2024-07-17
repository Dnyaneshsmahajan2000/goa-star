@extends('layouts.app',['title'=>'Add New User Role'])
@section('content')

    <div class='row'>
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('role.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf <!-- CSRF token for security -->

                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="name" class="form-label">Name<span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Name" required class="form-control" id="name" name="name" value="{{ old('name') }}">
                                    </div>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="opening_bal_type" class="form-label">Can Login</label>
                                        <select name="can_login" id="can_login" class="form-select">
                                            <option value="1" @if(old('can_login') == '1') selected @endif>Yes</option>
                                            <option value="0" @if(old('can_login') == '0') selected @endif>No</option>
                                        </select>
                                    </div>
                                    
                                </div>
                                


                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary mt-4" name="submit">Add User Role</button>
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
