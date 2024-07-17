@extends('layouts.app', ['title' => 'Add New Ledger'])
@section('content')

    <div class='row'>
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-header p-2 bg-primary ">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h6 class="mb-sm-0 text-white">Add New Ledger</h6>
                        <div class="page-title-right">
                            <a title="Alt + A" id='view-all-button' href='{{ @route('ledger.index') }}'
                                class=" btn btn-sm btn-light">
                                View All Ledger
                            </a>
                        </div>


                    </div>
                </div>

                <div class="card-body">

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    <form action="{{ route('ledger.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf <!-- CSRF token for security -->

                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="name" class="form-label">Ledger Name<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Name" required class="form-control"
                                            id="name" name="name" value="{{ old('name') }}">
                                    </div>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="group_id" class="form-label">Group<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <select name="group_id" id="group_id" class="form-select">
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('group_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="mobile" class="form-label">Mobile<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Mobile" required class="form-control"
                                            id="mobile" name="mobile" value="{{ old('mobile') }}">
                                    </div>
                                    @error('mobile')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" autofocus placeholder="Address" class="form-control"
                                            id="address" name="address" value="{{ old('address') }}">
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" autofocus placeholder="City" class="form-control"
                                            id="city" name="city" value="{{ old('city') }}">
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="state" class="form-label">State<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="State" required class="form-control"
                                            id="state" name="state" value="{{ old('state') }}">
                                    </div>
                                    @error('state')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="pincode" class="form-label">Pincode</label>
                                        <input type="text" autofocus placeholder="Pincode" class="form-control"
                                            id="pincode" name="pincode" value="{{ old('pincode') }}">
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" autofocus placeholder="Email" class="form-control"
                                            id="email" name="email" value="{{ old('email') }}">
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="gst_no" class="form-label">GST No</label>
                                        <input type="text" autofocus placeholder="GST No" class="form-control"
                                            id="gst_no" name="gst_no" value="{{ old('gst_no') }}">
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="gd_id" class="form-label">Godown</label>
                                        <select name="gd_id" id="gd_id" class="form-select">
                                            @foreach ($godowns as $godown)
                                                <option value="{{ $godown->id }}">{{ $godown->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="credit_limit" class="form-label">Credit Limit</label>
                                        <input type="text" autofocus placeholder="Credit Limit" class="form-control"
                                            id="credit_limit" name="credit_limit"
                                            value="{{ old('credit_limit', '0') }}">
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="bank_name" class="form-label">Bank Name</label>
                                        <input type="text" autofocus placeholder="Bank Name" class="form-control"
                                            id="bank_name" name="bank_name" value="{{ old('bank_name') }}">
                                    </div>

                                </div>

                                <!-- Continue adding input fields for the remaining columns -->

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="account_no" class="form-label">Account No</label>
                                        <input type="text" autofocus placeholder="Account No" class="form-control"
                                            id="account_no" name="account_no" value="{{ old('account_no') }}">
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="ifsc_code" class="form-label">IFSC Code</label>
                                        <input type="text" autofocus placeholder="IFSC Code" class="form-control"
                                            id="ifsc_code" name="ifsc_code" value="{{ old('ifsc_code') }}">
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="micr_code" class="form-label">MICR Code</label>
                                        <input type="text" autofocus placeholder="MICR Code" class="form-control"
                                            id="micr_code" name="micr_code" value="{{ old('micr_code') }}">
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="opening_balance" class="form-label">Opening Balance</label>
                                        <input type="text" autofocus placeholder="Opening Balance"
                                            class="form-control" id="opening_balance" name="opening_balance"
                                            value="{{ '0' }}">
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="opening_bal_type" class="form-label">Opening Balance Type</label>
                                        <select name="opening_bal_type" id="opening_bal_type" class="form-select">
                                            <option value="credit" @if (old('opening_bal_type') == 'credit') selected @endif>Credit
                                            </option>
                                            <option value="debit" @if (old('opening_bal_type') == 'debit') selected @endif>Debit
                                            </option>
                                        </select>
                                    </div>

                                </div>



                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary mt-4" name="submit">Add
                                            Ledger</button>
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
