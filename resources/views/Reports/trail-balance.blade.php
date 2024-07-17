@extends('layouts.app', ['title' => 'Trail Balance Report'])

@section('content')
    <?php
    $from_date = session('from_date');
    $to_date = session('to_date');
    ?><div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('report.trail-balance') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-xxl-3 col-md-3">
                                    <label for="type" class="form-label">Customer</label>
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
    @if (isset($ledgers))
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-2">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="text-white">Trail Balance</h4>
                    <h5 class="text-white" style="margin-top: 10px;">From Date: {{ date('d-m-Y', strtotime($from_date)) }} -
                        To Date: {{ date('d-m-Y', strtotime($to_date)) }}</h5>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class='table table-hover table-bordered'>
                            <thead>
                                <tr>
                                    <th width="60" style="text-align:center">Particular</th>
                                    <th width="10" style="text-align:center">Mobile No</th>
                                    <th width="10" style="text-align:right">Debit</th>
                                    <th width="10" style="text-align:right">Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalDebit = 0;
                                    $totalCredit = 0;
                                @endphp
                                @foreach ($ledgers as $data)
                                    <?php
                                    $ledger = \App\Models\Ledger::find($data['id']);
                                    // Get the sum of debit and credit from the transactions table for the ledger
                                    $sum = \App\Models\transaction::where('ledger_id', $data['id'])
                                        ->selectRaw('SUM(debit) as total_debit, SUM(credit) as total_credit')
                                        ->first();
                                    
                                    $totalDebit += $sum->total_debit ?? 0;
                                    $totalCredit += $sum->total_credit ?? 0;
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="{{ route('report.ledgerview', ['id' => $ledger['id']]) }}">
                                                {{ $ledger->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ $ledger->mobile }}
                                        </td>
                                        <td class="text-end">{{ $sum->total_debit ?? 0 }}</td>
                                        <td class="text-end">{{ $sum->total_credit ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end"><strong>{{ $totalDebit }}</strong></td>
                                    <td class="text-end"><strong>{{ $totalCredit }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
