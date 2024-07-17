@extends('layouts.app', ['title' => 'Voucher Report'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('report.voucher') }}" method="POST" class="needs-validation" novalidate>
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
                                    <label for="type" class="form-label">Type</label>
                                    <select name="vch_type" id="vch_type" class="form-control form-select">
                                        <option value="sale">Sale</option>
                                        <option value="order">Order</option>
                                        <option value="purchase">Purchase</option>
                                        <option value="sale_return">Sale Return</option>
                                        <option value="purchase_return">Purchase Return</option>


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
    <?php
            if(isset($vouchers)){

$from_date = session('from_date');
$to_date = session('to_date');
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-2">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="text-white"> {{ $godown_data }} {{ $vch_type }} Report</h4>
                    <h5 class="text-white" style="margin-top: 10px;">From Date: {{ date('d-m-Y', strtotime($from_date)) }} -
                        To Date: {{ date('d-m-Y', strtotime($to_date)) }}</h5>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id='datatable' class='table table-sm table-bordered table-hover bg-white'>
                            <thead class='bg-primary text-white'>
                                <tr style="text-align: center">
                                    <th>Sr.No</th>
                                    <th>Date</th>
                                    <th>Vch No</th>
                                    <th>Party</th>
                                    <th>Particular</th>
                                    <th>Total</th>
                                    <th>Gst Amt</th>
                                    <th>Grand Total</th>
                                </tr>
                            </thead>
                            <tbody class='list form-check-all'>
                                @php $srno = 1; @endphp
                                @foreach ($vouchers as $voucher)
                                    <tr>
                                        <td>{{ $srno++ }}</td>
                                        <td>{{ date('d-m-Y', strtotime($voucher->date)) }}</td>
                                        <td>{{ $voucher->vch_no }}</td>
                                        <td>{{ $voucher->ledger->name }}</td>
                                        <td>
                                            @php $total_amount = 0; @endphp
                                            <ul>
                                                @foreach ($voucher->VchItems as $item)
                                                    <li>{{ $item->item_data->name }} X {{ $item['quantity'] }} piece x
                                                        {{ $item['rate_after_discount'] }} =
                                                        {{ $item['total_after_disc'] }}</li>
                                                    @php $total_amount += $item['total_after_disc']; @endphp
                                                @endforeach
                                            </ul>
                                        </td>

                                        <td>{{ $voucher->total }}</td>
                                        <td>{{ $voucher->total_gst }}</td>
                                        <td>{{ $voucher->grand_total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find
                                    any orders for you search.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- end col -->
    </div>
    <!-- end col -->
    </div>
    </div>
@endsection
