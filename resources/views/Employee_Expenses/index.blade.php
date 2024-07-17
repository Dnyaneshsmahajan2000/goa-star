@extends('layouts.app', ['title' => 'Employee Expense'])
@section('content')
@php
    $permissions = Auth::user()->permission;
    $access = unserialize($permissions);
@endphp
    <div class="row">
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-header p-2 bg-primary ">
                    <div class="d-sm-flex align-items-end">
                        <h6 class="card-title flex-grow-1"></h6>
                        <div class="flex-shrink-0"> 
                            <a class="btn btn-primary btn-sm btn-light" href='{{ @route('emp-expenses.create') }}'
                                class=" btn btn-sm btn-primary text-white">
                                <i class="ri-add-line "></i>
                                Add New Emp Expenses
                            </a>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="card-body">
                    <div class='table-responsive'>
                        <table id='datatable' class='table table-sm table-bordered   table-hover bg-white'>
                            <thead class='bg-primary text-white'>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Details</th>
                                    <th>File</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody class='list form-check-all'>
                                @php $srno = 1; @endphp


                                @foreach ($empexp as $data)
                                    <tr>
                                        <td> {{ $srno++ }} </td>
                                        <td> {{ date('d-m-Y',strtotime($data->date)) }}</td>
                                        <td>{{ $data->amount }}</td>
                                        <td>
                                            {{ $data->details }}
                                        </td>
                                        <td>
                                            <a href="{{ asset($data->file) }}" target="_blank">
                                                <button class="btn btn-warning btn-sm">Show Image</button>
                                            </a>
                                        </td>

                                        <td>
                                            @if (Auth::user()->role->name == 'Admin' && is_null($data->is_verified))
                                                <button class="btn btn-sm btn-warning">Approve</button>
                                            @elseif (Auth::user()->role->name == 'Admin' && !is_null($data->is_verified))
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('Employee_Expenses.expense_edit', $data->id) }}">
                                                    Edit
                                                </a>

                                                <form action="{{ route('Employee_Expenses.destory', $data->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                                </form>
                                            @elseif (Auth::user()->role->name != 'Admin' && is_null($data->is_verified))
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('Employee_Expenses.expense_edit', $data->id) }}">
                                                    Edit
                                                </a>

                                                <form action="{{ route('Employee_Expenses.destory', $data->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-success">Approved</button>
                                            @endif
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
            </div><!-- end card -->
        </div>
    </div>


@stop
