@extends('layouts.app', ['title' => 'Edit User'])
@section('content')

    <div class='row'>
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-header p-2 bg-primary ">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="mb-sm-0 text-white">Edit User</h6>
                        <div class="page-title-right">
                            <a title="Alt + A" id='view-all-button' href='{{ @route('user.index') }}'
                                class="btn btn-sm btn-light">
                                View All Users
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT') <!-- This specifies the HTTP method as PUT for updating -->

                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="name" class="form-label"> Name<span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Enter Your Full Name" required class="form-control"
                                            id="name" name="name" value="{{ old('name', $user->name) }}">
                                    </div>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="mobile" class="form-label">Mobile<span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" placeholder="Enter Your Mobile" required class="form-control"
                                            id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}">
                                    </div>
                                    @error('mobile')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="dob" class="form-label">Date Of Birth<span class="text-danger font-weight-bold">*</span></label>
                                        <input type="date" placeholder="dob" required class="form-control"
                                            id="dob" name="dob" value="{{ old('dob', $user->dob) }}">
                                    </div>
                                    @error('dob')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="gender" class="form-label">Gender</label>
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="type" class="form-label">Type<span class="text-danger font-weight-bold">*</span></label>
                                        <select name="type" id="type" class="form-select">
                                            <option value="">--- Select Type ---</option>
                                            <option value="admin" {{ old('type', $user->type) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="master" {{ old('type', $user->type) == 'master' ? 'selected' : '' }}>Master</option>
                                            <option value="agent" {{ old('type', $user->type) == 'agent' ? 'selected' : '' }}>Agent</option>
                                            <option value="user" {{ old('type', $user->type) == 'user' ? 'selected' : '' }}>User</option>
                                        </select>
                                        @error('type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="salary" class="form-label">Salary</label>
                                        <input type="text" placeholder="Enter Salary" class="form-control"
                                            id="salary" name="salary" value="{{ old('salary', $user->salary) }}">
                                        @error('salary')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="can_login" class="form-label">Can Login</label>
                                        <select name="can_login" id="can_login" class="form-select">
                                            <option value="1" {{ old('can_login', $user->can_login) == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ old('can_login', $user->can_login) == '0' ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('can_login')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="address" class="form-label">Address</label>
                                        <textarea type="text" rows="1" placeholder="Enter Address" required class="form-control"
                                            id="address" name="address">{{ old('address', $user->address) }}</textarea>
                                    </div>
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="details" class="form-label">Other Details</label>
                                        <textarea type="text" rows="1" placeholder="Enter Other Details" required class="form-control"
                                            id="details" name="details">{{ old('details', $user->details) }}</textarea>
                                    </div>
                                    @error('details')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary mt-4" name="submit">Update User</button>
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
