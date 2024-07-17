@extends('layouts.app', ['title' => 'Add New Employee Expenses'])
@section('content')

    <div class='row'>
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-body">

                    <form
                        action="{{ route('Employee_Expenses.verify_employee_expense_save', ['id' => $employeeExpenses->id]) }}"
                        method="POST" class="needs-validation" novalidate>
                        @csrf <!-- CSRF token for security -->

                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="mobile" class="form-label">Amount<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="number" disabled autofocus placeholder="Amount" required
                                            class="form-control" id="amount" name="amount"
                                            value="{{ $employeeExpenses->amount }}">
                                    </div>
                                    @error('amount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="mobile" class="form-label">Approved Amount<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="number" autofocus placeholder="Amount" required class="form-control"
                                            id="approve_amount" name="approve_amount" value="{{ old('approve_amount') }}">
                                    </div>
                                    @error('amount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="name" class="form-label">Verified<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <select name="is_verified" id="is_verified" class="form-select">
                                            <option value="verified">Verified</option>
                                            <option value="rejected">Rejected</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="name" class="form-label">Expense Category<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <select name="exp_category" id="exp_category" class="form-select">
                                            @foreach ($exp_categorys as $exp_category)
                                                <option value="{{ $exp_category->id }}">{{ $exp_category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('exp_category')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="city" class="form-label">Reason</label>
                                        <input type="text" autofocus placeholder="Enter Details" class="form-control"
                                            id="reason" name="reason" value="{{ old('reason') }}">
                                    </div>

                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary mt-4" name="submit">Submit</button>
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
