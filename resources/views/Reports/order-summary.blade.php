@extends('layouts.app')

@section('content')
    <?php
    $from_date = session('from_date');
    $to_date = session('to_date');
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('order.summary') }}" method="POST" class="needs-validation" novalidate>
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
    @if (isset($data))
        <div class="row">
            <div class="col-lg-12">
                <div class="card p-2">
                    <div class="card-header text-center bg-primary text-white">
                        <h4 class="text-white">Order Summary Report {{ isset($group_name) ? $group_name : '' }}</h4>
                        <h5 class="text-white" style="margin-top: 10px;">From Date:
                            {{ date('d-m-Y', strtotime($from_date)) }} -
                            To Date: {{ date('d-m-Y', strtotime($to_date)) }}</h5>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-bordered">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Sr.No</th>
                                        <th class="sort" data-sort="customer_name">Item Name</th>
                                        <th class="sort" data-sort="mobile_no">Order Quantity</th>
                                        <th class="sort" data-sort="opening_balance">Available Stock</th>
                                        <th class="sort" data-sort="opening_balance">Difference</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @php
                                        $total = 0;
                                        $c = 1;

                                        // print_r($data);

                                    @endphp
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{ $c++ }}</td>
                                            <td class="supplier">{{ $d['item_name'] }}</td>
                                            <td class="user_name">{{ $d['quantity'] }}</td>
                                            <td class="name">{{ $d['stock'] }}</td>
                                            <td>
                                                @php
                                                    $difference = $d['stock'] - $d['quantity'];
                                                    $class = $difference >= 0 ? 'text-success' : 'text-danger';
                                                @endphp
                                                <span class="{{ $class }}">{{ abs($difference) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a"
                                        style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find
                                        any orders for you search.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#table-1").dataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Order Summary Report'
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
