@extends('layouts.app', ['title' => 'Employee Attendance'])
@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('user.emp-attendance-save') }}" method="post">
        @csrf

        <div class="row mb-3">
            <div class="col-lg-4">
                <label for="attendance_date" class="form-label">Date:</label>
                <input type="date" class="form-control border-1" id="date-field" data-provider="flatpickr" data-time="true"
                    placeholder="Select Date-time" value="{{ date('Y-m-d') }}" name="date" />

            </div>
            <div class="col-lg-4 mt-4">

                <button type="submit" name="date_submit" class="btn btn-primary">Show</button>
            </div>

        </div>
    </form>
    <?php if (isset($users)) { ?>
    <form action="{{ route('attendance.save') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle table-nowrap" id="customerTable">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Sr.No</th>
                                        <th class="sort" data-sort="email">EMPLOYEES NAME</th>
                                        <th class="sort" data-sort="phone">PRESENT</th>
                                        <th class="sort" data-sort="type">ABSENT</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @php $c = 1; @endphp
                                    @foreach ($users as $atten)
                                        @php
                                            // Get attendance for the current user
                                            $att = \App\Models\attendance::where('emp_id', $atten->id)
                                                ->where('date', $selected_date)
                                                ->value('attendance');
                                        @endphp

                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <td class="mobile">
                                                <input type="hidden" value="{{ $selected_date }}" name="date">
                                                <a href="">{{ ucwords($atten->name) }}</a>
                                            </td>
                                            <td>
                                                <input type="radio" name="attendance[{{ $atten->id }}]" value="present"
                                                    {{ $att == 'present' ? 'checked' : '' }}> Present
                                            </td>
                                            <td>
                                                <input type="radio" name="attendance[{{ $atten->id }}]" value="absent"
                                                    {{ $att == 'absent' ? 'checked' : '' }}> Absent
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center mb-3">
                                <button type="button" class="btn btn-sm btn-success" onclick="markAll('present')">Mark All
                                    Present</button>
                                <button type="button" class="btn btn-sm btn-warning" onclick="markAll('absent')">Mark All
                                    Absent</button>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Save Attendance</button>
                            </div>
                        </div>
                    </div>
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    </form>
    <?php } ?>
    <!-- end form -->
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
    </script>
@endsection
