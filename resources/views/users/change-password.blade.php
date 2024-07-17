@extends('layouts.app', ['title' => 'Change Password'])
@section('content')
    <div class='row'>
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-header p-2 bg-primary ">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="mb-sm-0 text-white">Change Password</h6>
                        <div class="page-title-right">
                            <a title="Alt + A" id='view-all-button' href='{{ @route('user.index') }}'
                                class=" btn btn-sm btn-light">
                                View All Users
                            </a>
                        </div>


                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.password.update', $user->id) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf

                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="current_password" class="form-label">Current Password<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="password" placeholder="Enter Current Password" required
                                            class="form-control" id="current_password" name="old_password">
                                    </div>
                                    @error('current_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="new_password" class="form-label">New Password<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="password" placeholder="Enter New Password" required
                                            class="form-control" id="new_password" name="new_password">
                                    </div>
                                    @error('new_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="confirm_password" class="form-label">Confirm New Password<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="password" placeholder="Confirm New Password" required
                                            class="form-control" id="confirm_password" name="confirm_password">
                                    </div>
                                    @error('new_password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary mt-4" name="submit">Change
                                            Password</button>
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
