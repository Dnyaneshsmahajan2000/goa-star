@extends('layouts.app', ['title' => 'Add New Employee Expenses'])
@section('content')

    <div class='row'>
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-header p-2 bg-primary ">
                    <div class="d-sm-flex align-items-end">
                        <h6 class="card-title flex-grow-1"></h6>
                        <div class="flex-shrink-0">
                            <a class="btn btn-primary btn-sm btn-light" href='{{ @route('emp-expenses.index') }}'
                                class=" btn btn-sm btn-primary text-white">
                                View All Expenses
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('emp-expenses.store') }}" method="POST" class="needs-validation" novalidate
                        enctype="multipart/form-data">
                        @csrf <!-- CSRF token for security -->

                        <div class="live-preview">
                            <div class="row gy-4">
                                <?php
            if (auth()->user()->role->name == 'Admin') {
                                ?>
                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="name" class="form-label">Expense Category<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <select name="exp_category" id="exp_category" class="form-select">
                                            <option value="">-- Select Expense Category --</option>

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
                                        <label for="group_id" class="form-label">Employee<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <select name="emp_id" id="emp_id" class="form-select">
                                            <option value="">-- Select Employee Name --</option>

                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('emp_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <?php } ?>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="mobile" class="form-label">Amount<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="number" autofocus placeholder="Amount" required class="form-control"
                                            id="amount" name="amount" value="{{ old('amount') }}">
                                    </div>
                                    @error('amount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="file" class="form-label">File</label>
                                        <input type="file" class="form-control" id="file" name="file">
                                    </div>
                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="city" class="form-label">Details</label>
                                        <input type="text" autofocus placeholder="Enter Details" class="form-control"
                                            id="details" name="details" value="{{ old('details') }}">
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
