@extends('layouts.app', ['title' => 'Receivable Report'])

@section('content')
    <?php
    $from_date = session('from_date');
    $to_date = session('to_date');
    ?><div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('report.receivable') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-xxl-3 col-md-3">
                                    <label for="type" class="form-label">Godown</label>
                                    <select name="godown_id" id="godown_id" class="form-control form-select">
                                        @if (Auth::user()->role->name == 'SuperAdmin')
                                            <option value="All">All Godown</option>
                                        @endif
                                        @foreach ($godowns as $godown)
                                            <option value="{{ $godown['id'] }}">{{ $godown['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xxl-2 col-md-2">
                                    <div>
                                        <button type="submit" class="btn btn-secondary btn-block mt-4"
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-2">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="text-white">Receivable Report {{ isset($group_name) ? $group_name : '' }}</h4>
                    <h5 class="text-white" style="margin-top: 10px;">From Date: {{ date('d-m-Y', strtotime($from_date)) }} -
                        To Date: {{ date('d-m-Y', strtotime($to_date)) }}</h5>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class='table table-hover table-bordered'>
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th width="60">Particular</th>
                                    <th width="10" style="text-align:right">Opening Balance</th>
                                    <th width="10" style="text-align:right">Debit</th>
                                    <th width="10" style="text-align:right">Credit</th>
                                    <th width="10" style="text-align:right">Closing Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                    $grand_total_opening_cr = $grand_total_opening_dr = $grand_total_credit = $grand_total_debit = 0;
                                @endphp
                                @if (isset($groups))
                                    @foreach ($groups as $group)
                                        <tr>
                                            <td>
                                                   <a href="{{ route('report.groupreport', ['group_id' => $group->id]) }}">
                                                    {{ $group['group_name'] }}
                                                </a>
                                            </td>
                                            <td class="text-end">
                                                {{ $group->get_totals()['opening_cr'] - $group->get_totals()['opening_dr'] }}
                                                {{ $group->get_totals()['opening_cr'] > $group->get_totals()['opening_dr'] ? 'Cr' : 'Dr' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $group->get_totals()['debit'] }}
                                                {{ $group->get_totals()['debit'] > 0 ? 'Dr' : '' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $group->get_totals()['credit'] }}
                                                {{ $group->get_totals()['credit'] > 0 ? 'Cr' : '' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $group->get_totals()['credit'] - $group->get_totals()['debit'] }}
                                                {{ $group->get_totals()['credit'] - $group->get_totals()['debit'] > 0 ? 'Cr' : 'Dr' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset

                                @if (isset($parties))
                                    @foreach ($parties as $ledger)
                                        <?php
                                        $opening_balance = \App\Models\Transaction::where('ledger_id', $ledger->id)
                                            ->whereDate('date', '<', $from_date)
                                            ->get();

                                        $total_opening_balance_debit = $opening_balance->sum('debit');
                                        $total_opening_balance_credit = $opening_balance->sum('credit');

                                        if ($total_opening_balance_debit > $total_opening_balance_credit) {
                                            $opening_balance = $total_opening_balance_debit - $total_opening_balance_credit . ' Dr';
                                        } else {
                                            $opening_balance = $total_opening_balance_debit - $total_opening_balance_credit . ' Cr';
                                        }
                                        $transactions = \App\Models\Transaction::where('ledger_id', $ledger->id)
                                            ->whereBetween('date', [$from_date, $to_date])
                                            ->get();

                                        $total_debit = $transactions->sum('debit');
                                        $total_credit = $transactions->sum('credit');
                                        if ($total_debit > $total_credit) {
                                            $balance = $total_debit - $total_credit . ' Dr';
                                        } else {
                                            $balance = $total_credit - $total_debit . ' Cr';
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="{{ route('report.ledgerview', ['id' => $ledger['id']])  }}">
                                                    {{ $ledger['name'] }}
                                                </a>
                                            </td>
                                            <td class="text-end">
                                                {{ $opening_balance }}
                                            </td>
                                            <td class="text-end">{{ $total_debit }}</td>
                                            <td class="text-end">{{ $total_credit }}</td>
                                            <td class="text-end">{{ $balance }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
