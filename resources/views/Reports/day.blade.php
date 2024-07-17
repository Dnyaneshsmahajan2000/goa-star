@extends('layouts.app', ['title' => 'Day Report', 'date_type' => '2'])

@section('content')
    <?php
    $from_date = session('from_date');
    $to_date = session('to_date');
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-2">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="text-white">Day Report</h4>
                    <p style="margin-top: 10px;">{{ date('d-m-Y') }}</p>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class='table table-hover table-bordered'>
                            <thead>
                                <tr>
                                    <th width="10" style="text-align:center">Date</th>
                                    <th width="60" style="text-align:center">Particular</th>
                                    <th width="10" style="text-align:center">Vch No</th>
                                    <th width="10" style="text-align:right">Debit</th>
                                    <th width="10" style="text-align:right">Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $data)
                                    <tr>
                                        <td style="text-align:center">{{  date('d-m-Y',strtotime($data->date)) }}</td>
                                        <td >{{ $data->ledger ? $data->ledger->name : 'N/A' }}</td>
                                        <td style="text-align:center">{{ $data->vch_no }}</td>
                                        <td class="text-end">{{ $data->debit }}</td>
                                        <td class="text-end">{{ $data->credit }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align:right"><strong>Total</strong></td>
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
@endsection

@push('scripts')
