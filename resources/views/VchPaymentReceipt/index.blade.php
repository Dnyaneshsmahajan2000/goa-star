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
                    <a title="Alt + A" id='view-all-button' href='{{ route('vch.pr.create', ['vch_type' => $vch_type]) }}'
                        class="btn btn-sm btn-light">
                        ADD NEW {{ $vch_type }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table id='datatable' class='table table-sm table-bordered table-hover bg-white'>
                    <thead class='bg-primary text-white'>
                        <tr style="text-align: center">
                            <th>Sr.No</th>
                            <th>Date</th>
                          
                            <th>Party</th>
                            <th>Mode</th>
                            <th>Bank</th>
                            <th>Amount</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class='list form-check-all'>
                        @php $srno = 1; @endphp
                        @foreach ($Vouchers as $voucher)
                            <tr>
                                <td>{{ $srno++ }}</td>
                                <td>{{ $voucher->date }}</td>
                              
                                <td>{{ $voucher->parties->name }}</td>
                                

                                <td>{{ $voucher->mode }}</td>
                                <td>{{ $voucher->banks ? $voucher->banks->name : 'No Bank' }}</td>
                                <td>{{ $voucher->amount }}</td>
                                  <td>{{ $voucher->details }}</td>

                             <td>  
                                <a class="btn btn-sm btn-primary"
                                href="{{ route('vch.pr.edit', [$voucher->vch_type, $voucher->vch_no]) }}">Edit</a>
                                <form action="{{ route('vch.pr.delete', [$voucher->vch_type,$voucher->id]) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
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
