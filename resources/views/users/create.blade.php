@extends('layouts.app', ['title' => 'Add New User'])
@section('content')

    <div class='row'>
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-header p-2 bg-primary ">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="mb-sm-0 text-white">Add New Employee</h6>
                        <div class="page-title-right">
                            <a title="Alt + A" id='view-all-button' href='{{ @route('user.index') }}'
                                class=" btn btn-sm btn-light">
                                View All Users
                            </a>
                        </div>


                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('user.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf <!-- CSRF token for security -->

                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="name" class="form-label"> Name<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Enter Your Full Name" required class="form-control"
                                            id="name" name="name" value="{{ old('name') }}">
                                    </div>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="mobile" class="form-label">Mobile<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Enter Your Mobile" required class="form-control"
                                            id="mobile" name="mobile" value="{{ old('mobile') }}">
                                    </div>
                                    @error('mobile')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="dob" class="form-label">Date Of Birth<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="date" autofocus placeholder="dob" required class="form-control"
                                            id="dob" name="dob" value="{{ old('dob') }}">
                                    </div>
                                    @error('dob')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="gd_id" class="form-label">Gender</label>
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                        @error('gender')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    </div>

                                </div>
                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="type" class="form-label">Type<span
                                            class="text-danger font-weight-bold">*</span></label>
                                        <select name="type" id="type" class="form-select">
                                            <option value="">--- Select Type ---</option>
                                            <option value="admin">Admin</option>
                                            <option value="master">Master</option>
                                            <option value="agent">Agent</option>
                                            <option value="user">User</option>
                                        </select>
                                        @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    </div>

                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="email" class="form-label">Salary</label>
                                        <input type="text" autofocus placeholder="Enter Salary" class="form-control"
                                            id="salary" name="salary" value="{{ old('salary') }}">
                                            @error('salary')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="opening_bal_type" class="form-label">Can Login</label>
                                        <select name="can_login" id="can_login" class="form-select">
                                            <option value="1" @if (old('can_login') == '1') selected @endif>Yes
                                            </option>
                                            <option value="0" @if (old('can_login') == '0') selected @endif>No
                                            </option>
                                        </select>
                                        @error('can_login')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    </div>

                                </div>
                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="address" class="form-label">Address</label>
                                        <textarea type="text" rows="1" autofocus placeholder="Enter Address" required class="form-control"
                                            id="address" name="address" value="{{ old('address') }}"></textarea>
                                    </div>
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="address" class="form-label">Other Details</label>
                                        <textarea type="text" rows="1" autofocus placeholder="Enter Other Details" required class="form-control"
                                            id="details" name="details" value="{{ old('details') }}"></textarea>
                                    </div>
                                    @error('details')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="email" class="form-label">Password<span
                                            class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Enter Password" class="form-control"
                                            id="password" name="password" value="{{ old('password') }}">
                                            @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    </div>


                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary mt-4" name="submit">Add
                                            User</button>
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
