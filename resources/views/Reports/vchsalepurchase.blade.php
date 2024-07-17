@extends('layouts.app', ['title' => $vch_type . ' Report'])

@section('content')

    <div class="row">
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-header py-2">
                    <div class="d-flex align-items-end ">
                        <h6 class="card-title flex-grow-1"></h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class='table-responsive'>
                        <table id='' class='table table-sm table-bordered table-hover bg-white'>
                            <thead class='bg-primary text-white'>
                                <tr>
                                    <th>Month</th>
                                    <th>Count</th>
                                    <th>Grand Total</th>
                                </tr>
                            </thead>
                            <tbody class='list form-check-all'>
                                @php
                                    $srno = 1;
                                    $totalSum = 0;
                                @endphp
                                @foreach ($formattedReport as $type)
                                    <tr>
                                        <td> <a
                                                href="{{ route('vch.gst.index', [
                                                    'vch_type' => $vch_type,
                                                    'start_date' => $type->year . '-' . str_pad($type->month, 2, '0', STR_PAD_LEFT) . '-01',
                                                    'end_date' => $type->year . '-' . str_pad($type->month, 2, '0', STR_PAD_LEFT) . '-31',
                                                ]) }}">
                                                {{ $type->month }}-{{ $type->year }}</a></td>

                                        <td>{{ $type->count }}</td>
                                        <td>{{ $type->total }}</td>
                                    </tr>
                                    @php
                                        $totalSum += $type->total; // Add total to sum
                                    @endphp
                                @endforeach

                                <!-- Last row for total sum -->
                                <tr>
                                    <td colspan="2" class="text-right"><strong>Total Grand Total:</strong></td>
                                    <td><strong>{{ $totalSum }}</strong></td>
                                </tr>
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
            </div><!-- end card -->
        </div>
    </div>

@stop
