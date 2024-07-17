@extends('layouts.app', ['title' => 'Highest Customer'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('type.report') }}" method="GET" class="needs-validation" novalidate>
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
                                    <select name="type" id="type" class="form-control form-select">
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
    if(isset($ledgers)){
    $from_date = session('from_date');
    $to_date = session('to_date');
    ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card p-2">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="text-white">Highest Customer Report</h4>
                    <h5 class="text-white" style="margin-top: 10px;">From Date: {{ date('d-m-Y', strtotime($from_date)) }} -
                        To Date: {{ date('d-m-Y', strtotime($to_date)) }}</h5>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-33" class="table table-striped table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Sr.No</th>
                                    <th class="sort" data-sort="customer_name">Name</th>
                                    <th class="sort" data-sort="mobile_no">Mobile Number</th>
                                    <th class="sort" data-sort="opening_balance">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @php
                                    $total = 0;
                                @endphp

                                @foreach ($ledgers as $ledger)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="supplier">

                                            <a href="{{ route('report.ledgerview', ['id' => $ledger->ledger->id]) }}">
                                                {{ ucwords($ledger->ledger->name) }}
                                            </a>
                                        </td>
                                        <td class="user_name">{{ $ledger->ledger->mobile }}</td>
                                        <td>{{ $ledger->total_amount }}</td>
                                        @php $total += $ledger->total_amount; @endphp
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <h4>Total</h4>
                                    </td>
                                    <td colspan="1">
                                        <h4>{{ $total }}</h4>
                                    </td>
                                </tr>
                            </tfoot>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#table-33").dataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Item Stock Report'
                }, 'print'],
                "pageLength": 50,
                "bPaginate": false,
                "ordering": false
            });
        });
    </script>

    <script>
        $("#from_date").datepicker({
            dateFormat: "dd-mm-yy"
        }).datepicker("setDate", "today");
        $("#to_date").datepicker({
            dateFormat: "dd-mm-yy"
        }).datepicker("setDate", "today");
    </script>
@endpush
