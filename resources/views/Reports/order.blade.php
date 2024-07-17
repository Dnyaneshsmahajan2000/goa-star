@extends('layouts.app', ['title' => 'Order Report'])

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('customer.report') }}" method="GET" class="needs-validation" novalidate>

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
    <?php
if(isset($parties_data)){?>
    <?php
    $from_date = session('from_date');
    $to_date = session('to_date');
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-2">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="text-white">Order  Report {{ isset($group_name) ? $group_name : '' }}</h4>
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
                                    <th>Date</th>
                                    <th>Customer Name</th>
                                    <th>Items</th>
                                    <th>Gst Amt</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class='list form-check-all'>
                                @php
                                    $srno = 1;
                                    $totalSum = 0;
                                @endphp

                                @foreach ($parties_data as $party)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d-m-Y', strtotime($party->date)) }}</td>
                                        <td>{{ $party->ledger->name }}</td>
                                        <td>
                                            @php $total_amount = 0; @endphp
                                            <ul>
                                                @foreach ($party->VchItems as $item)
                                                    <li>{{ $item->item_data->name }} X {{ $item['quantity'] }} piece x
                                                        {{ $item['rate_after_discount'] }} =
                                                        {{ $item['total_after_disc'] }}</li>
                                                    @php $total_amount += $item['total_after_disc']; @endphp
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $party->total_gst }}</td>
                                        <td>{{ $party->grand_total }}</td>


                                    </tr>
                                    @php
                                        $totalSum += $party->grand_total;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Total Grand Total:</strong></td>
                                    <td><strong>{{ $totalSum }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class='noresult' style='display: none'>
                            <div class='text-center'>
                                <lord-icon src='https://cdn.lordicon.com/msoeawqm.json' trigger='loop'
                                    colors='primary:#121331,secondary:#08a88a' style='width:75px;height:75px'></lord-icon>
                                <h5 class='mt-2'>Sorry! No Result Found</h5>
                                <p class='text-muted mb-0'>We've searched more than 150+ Orders We did not find any orders
                                    for your search.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
    </div>
    <?php }?>
@stop
