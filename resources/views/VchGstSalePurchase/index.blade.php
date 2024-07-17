@extends('layouts.app', ['title' => 'All ' . $vch_type])
@section('content')
@php
    $permissions = Auth::user()->permission;
    $access = unserialize($permissions);
@endphp
    <div class="card">
        <div class="card-header p-2 bg-primary">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="mb-sm-0 text-white">View All {{ $vch_type }}</h6>
                <div class="page-title-right">
                    <a title="Alt + A" id='view-all-button' href='{{ route('vch.gst.create', ['vch_type' => $vch_type]) }}'
                        class="btn btn-sm btn-light">
                        Add New {{ $vch_type }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table id='ledgertable' class='table table-sm table-bordered table-hover bg-white'>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class='list form-check-all'>
                        @php $srno = 1; @endphp
                        @foreach ($Vouchers as $voucher)
                            <tr>
                                <td>{{ $srno++ }}</td>
                                <td>{{ date('d-m-Y',strtotime($voucher->date)) }}</td>
                                <td>{{ $voucher->vch_no }}</td>
                                <td>{{ $voucher->ledger->name }}</td>
                                <td>
                                    @php $total_amount = 0; @endphp
                                    <ul>
                                        @foreach ($voucher->VchItems as $item)
                                            <li>{{ $item->item_data->name }} X {{ $item['quantity'] }} piece x
                                                {{ $item['rate_after_discount'] }} = {{ $item['total_after_disc'] }}</li>
                                            @php $total_amount += $item['total_after_disc']; @endphp
                                        @endforeach
                                    </ul>
                                </td>

                                <td>{{ $voucher->total }}</td>
                                <td>{{ $voucher->total_gst }}</td>
                                <td>{{ $voucher->grand_total }}</td>
                                <td>
                                    <?php  if($vch_type=='order'){?>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('order.gst.to.sale', ['sale', $voucher->id]) }}">Convert
                                        Order</a>
                                    <?php } ?>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('vch.gst.edit', [$voucher->vch_type, $voucher->id]) }}">Edit</a>

                                    <form class="d-inline"
                                        action="{{ route('vch.gst.destroy', [$voucher->vch_type, $voucher->id]) }}"
                                        method="post">
                                        @csrf <!-- Include the CSRF token -->
                                        @method('DELETE') <!-- Specify the DELETE method -->
                                        <!-- Other form fields or hidden inputs if needed -->
                                        <button class='btn btn-sm btn-danger' type='submit'>Delete</button>
                                    </form>



                                </td>
                            </tr>
                        @endforeach
                    </tbody>
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
    </div>
@endsection
