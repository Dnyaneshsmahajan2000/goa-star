@extends('layouts.app', ['title' => 'Bank Report'])

@section('content')
    <?php
    $from_date = session('from_date');
    $to_date = session('to_date');
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-2">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="text-white">Bank Report {{ isset($group_name) ? $group_name : '' }}</h4>
                    <h5 class="text-white" style="margin-top: 10px;">From Date: {{ date('d-m-Y', strtotime($from_date)) }} -
                        To Date: {{ date('d-m-Y', strtotime($to_date)) }}</h5>
                    </h4>
                </div>
                <div class="card-body">
                    <div class='table-responsive'>
                        <table id='datatable' class='table table-sm table-bordered table-hover bg-white'>
                            <thead class='bg-primary text-white'>
                                <tr>
                                    <th>Sr. no.</th>
                                    <th>Bank Name</th>
                                    <th>Opening Balance</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody class='list form-check-all'>
                                @php
                                    $count = 1;
                                    $totalBalance = 0;
                                @endphp

                                @foreach ($banks as $bank)
                                    @php
                                        $opening_balance_bank_cr = \App\Models\transaction::where(
                                            'ledger_id',
                                            $bank->id,
                                        )
                                            ->where('date', '<', session('from_date'))
                                            ->sum('credit');
                                        $opening_balance_bank_dr = \App\Models\transaction::where(
                                            'ledger_id',
                                            $bank->id,
                                        )
                                            ->where('date', '<', session('from_date'))
                                            ->sum('debit');
                                        $opening_balance = $opening_balance_bank_dr - $opening_balance_bank_cr;

                                        $period_credit = \App\Models\transaction::where('ledger_id', $bank->id)
                                            ->whereBetween('date', [session('from_date'), session('to_date')])
                                            ->sum('credit');

                                        $period_debit = \App\Models\transaction::where('ledger_id', $bank->id)
                                            ->whereBetween('date', [session('from_date'), session('to_date')])
                                            ->sum('debit');

                                        $total_balance =$period_debit - $period_credit;

                                    @endphp
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>
                                            <a href="{{ route('report.ledgerview', ['id' => $bank->id]) }}">
                                                {{ $bank->name }}
                                            </a>
                                        </td>
                                        <td>{{ $opening_balance }}</td>
                                        <td class="{{ $total_balance < 0 ? 'text-danger' : '' }}">{{ $total_balance }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr bgcolor="lightgrey">
                                    <td colspan="3">
                                        <h4><b>Total</b></h4>
                                    </td>
                                    <td>
                                        <h4>{{ $totalBalance }}</h4>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class='noresult' style='display: none'>
                            <div class='text-center'>
                                <lord-icon src='https://cdn.lordicon.com/msoeawqm.json' trigger='loop'
                                    colors='primary:#121331,secondary:#08a88a' style='width:75px;height:75px'></lord-icon>
                                <h5 class='mt-2'>Sorry! No Result Found</h5>
                                <p class='text-muted mb-0'>We've searched more than 150+ Orders We did not find
                                    any orders for you search.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
    </div>
@endsection
