@extends('layouts.app', ['title' => 'Employee Attendance'])
@section('content')
    <?php
    
    $currentMonth = date('Y-m');
    ?>
    <form action="{{ route('user.generate_salary_view') }}" method="post">
        @csrf

        <div class="row mb-3">
            <div class="col-lg-4">
                <label for="attendance_date" class="form-label">Month:</label>
                <input type="month" class="form-control border-1" id="date-field" data-provider="flatpickr" data-time="true"
                    placeholder="" value="{{ old('month', $currentMonth) }}" name="month" />
            </div>
            <div class="col-lg-4">
                <label for="attendance_date" class="form-label">Paid Holdiays:</label>
                <input type="text" class="form-control border-1" id="date-field" data-provider="flatpickr"
                    data-time="true" placeholder="" value="" name="holidays" />

            </div>
            <div class="col-lg-4 mt-4">
                <button type="submit" name="date_submit" class="btn btn-primary">Generate Salary</button>
            </div>

        </div>
    </form>
    @if (isset($generate_salary))
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle table-nowrap" id="customerTable">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Sr.No</th>
                                        <th class="sort" data-sort="email">Name</th>
                                        <th class="sort" data-sort="phone">Month</th>
                                        <th class="sort" data-sort="type">Salary</th>
                                        <th class="sort" data-sort="type">Expenses</th>
                                        <th class="sort" data-sort="action">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @php
                                        Session::flash('data', $generate_salary);
                                        Session::flash('holidays', $holidays);
                                        Session::flash('lastMonthYear', $lastMonthYear);
                                        Session::flash('lastMonthMonth', $lastMonthMonth);

                                        $c = 1;
                                        $currentMonth = Carbon\Carbon::create(
                                            $lastMonthYear,
                                            $lastMonthMonth,
                                            1,
                                        )->format('M-y');
                                    @endphp
                                    @foreach ($generate_salary as $info)
                                        @php
                                            $ledger_id = DB::table('users')
                                                ->where('id', $info->emp_id)
                                                ->value('ledger_id');
                                            $totalDaysPresent = $info->present_count + $holidays;
                                            $currentNumberOfDays = Carbon\Carbon::create(
                                                $lastMonthYear,
                                                $lastMonthMonth,
                                            )->daysInMonth;
                                            $totalSalary = ($info->salary * $totalDaysPresent) / $currentNumberOfDays;
                                            $totalApprovedAmount = $info->total_approved_amount;
                                            $total = $totalApprovedAmount + $totalSalary;
                                        @endphp
                                        <tr>
                                            <th>{{ $c }}</th>
                                            <td class="mobile"><a
                                                    href="{{ route('report.ledgerview', ['id' => $ledger_id]) }}">{{ ucwords($info->name) }}</a>
                                            </td>
                                            <td class="gender">{{ $currentMonth }}</td>
                                            <td>{{ number_format($totalSalary, 2) }}</td>
                                            <td>{{ number_format($totalApprovedAmount, 2) }}</td>
                                            <td>{{ number_format($total, 2) }}</td>
                                        </tr>
                                        @php
                                            $c++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Only display the "Convert To Transactions" button if salary is not generated for the previous month -->
                            @php
                                $isSalaryGenerated = false;
                                $previousMonthYear = $lastMonthYear;
                                $previousMonthMonth = $lastMonthMonth - 1;
                                if ($previousMonthMonth == 0) {
                                    $previousMonthYear -= 1;
                                    $previousMonthMonth = 12;
                                }

                                // Check if salary transactions are generated for the previous month
                                foreach ($generate_salary as $info) {
                                    if (isset($info->month_year) && isset($info->month_month)) {
                                        if (
                                            $info->month_year == $previousMonthYear &&
                                            $info->month_month == $previousMonthMonth
                                        ) {
                                            $isSalaryGenerated = true;
                                            break;
                                        }
                                    }
                                }
                            @endphp

                            @if (!$isSalaryGenerated)
                                <a class="btn btn-success" href="{{ route('user.convert_salary_to_transactions') }}">Convert
                                    To Transactions</a>
                            @endif

                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a"
                                        style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                                        orders for your search.</p>
                                </div>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end form -->
    @endif

    <div class="noresult" style="display: none">
        <div class="text-center">
            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
            <h5 class="mt-2">Sorry! No Result Found</h5>
            <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find
                any orders for you search.</p>
        </div>
    </div>

    <!-- end main-content -->

    <script>
        function markAll(status) {
            var radios = document.querySelectorAll('input[type="radio"]');
            for (var i = 0; i < radios.length; i++) {
                radios[i].checked = (radios[i].value === status);
            }
        }

        /*  function convertAndSave() {
             const generate_salary = @json($generate_salary ?? []);
             const holidays = @json($holidays ?? 0);

             if (generate_salary.length > 0) {
                 if (confirm('Are you sure you want to convert these salaries to transactions?')) {
                     fetch('{{ route('user.convert_salary_to_transactions') }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': '{{ csrf_token() }}'
                         },
                         body: JSON.stringify({
                             generate_salary,
                             holidays
                         })
                     }).then(response => response.json()).then(data => {
                         if (data.success) {
                             alert('Transactions saved successfully!');
                         } else {
                             alert('An error occurred. Please try again.');
                         }
                     }).catch(error => {
                         console.error('Error:', error);
                         alert('An error occurred. Please try again.');
                     });
                 }
             } else {
                 alert('No salary data available to convert.');
             }
         } */
    </script>
@endsection
