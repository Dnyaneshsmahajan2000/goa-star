@extends('layouts.app', ['title' => '30 Day Debtor Report'])

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('report.ledger') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="live-preview">
                            <div class="row gy-4">  
                            <div class="col-xxl-3 col-md-3">
                                    <label for="type" class="form-label">Godowns</label>
                                    <select name="godown_id" id="godown_id" class="form-control form-select">
                                        @if (Auth::user()->role->name == 'SuperAdmin')
                                            <option value="All">All Godown</option>
                                        @endif
                                        @foreach ($godowns as $godown)
                                            <option value="{{ $godown['id'] }}">{{ $godown['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-3 col-md-3">
                                    <label for="days" class="form-label">Days</label>
                                    <input type="text" class="form-control" value="30" name="days" id="days"
                                        required>
                                </div>

                                <div class="col-xxl-2 col-md-2">
                                    <div>
                                        <button type="submit" class="btn btn-secondary btn-block mt-4" value="submit"
                                            name="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <?php
    $from_date = session('from_date');
    $to_date = session('to_date');
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-2">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="text-white">30 Day Debtor Report</h4>
                    <h5 class="text-white" style="margin-top: 10px;">From Date: {{ date('d-m-Y', strtotime($from_date)) }} -
                        To Date: {{ date('d-m-Y', strtotime($to_date)) }}</h5>
                    </h4>
                </div>
                <div class="card p-2">

                    <div class="table-responsive">
                        <table id="table-33" class="table table-striped table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Mobile Number</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                 @if (isset($data))
                                          @foreach ($data as $index => $ledger)
                                        <tr>
                                            <th>{{ $index + 1 }}</th>
                                            <td class="supplier">
                                                <a href="{{ route('report.ledgerview', ['id' => $ledger['ledger_id']]) }}">
                                                    {{ ucwords($ledger['name']) }}
                                                </a>
                                            </td>
                                            <td class="user_name">{{ $ledger['mobile_no'] }}</td>
                                            <td>{{ $ledger['balance'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No debtors found within the specified period.
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
    </div>
    </div>
    </div>
@endsection
