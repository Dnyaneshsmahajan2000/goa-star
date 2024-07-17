@extends('layouts.app', ['title' => 'Update Company'])
@section('content')

    <div class="card card-body">
        <form method="POST" action="{{ route('changepassword.save') }}">
            @csrf <div class="row">

                <div class="col-md">
                    <label for="useremail" class="form-label">New Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="new_password" name="new_password"
                        placeholder="Enter new password" required>
                    <div class="invalid-feedback">
                        Please enter new password
                    </div>
                </div>

                <div class="col-md">
                    <label for="useremail" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                        placeholder="Enter confirm password" required>
                    <div class="invalid-feedback">
                        Please enter confirm password
                    </div>
                </div>
                <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                    <h5 class="fs-13">Password must contain:</h5>
                    <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                    <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)</p>
                    <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                    <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>
                </div>
            </div>

            <div class="row" style="margin-top:3% ;" align="center">
                <center>
                    <div class="col-md-2">

                        <button class="btn btn-success w-100" type="submit">Save</button>

                    </div>
                </center>
            </div>


        </form>

    </div>
@stop
