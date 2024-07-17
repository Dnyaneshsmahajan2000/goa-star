@extends('layouts.app', ['title' => 'Ledgers'])
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
                            <a class="btn btn-primary btn-sm btn-light" href="{{ route('ledger.create') }}">
                                <i class="ri-add-line "></i>
                                Add New Ledger

                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class='table-responsive '>
                        <table id='datatable' class='table table-sm table-bordered scrollable  table-hover bg-white'>
                            <thead class='bg-primary text-white'>
                                <tr style="vertical-align: top;">
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Group Name</th>
                                    <th>Mobile No</th>
                                    <th>Godown</th>
                                    <th>Credit Limit</th>
                                    <th>Opening Balance</th>
                                    <th>Balance Type</th>
                                    @if (isset($access['Ledgers']) && $access['Ledgers']['update'] == '1')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class='list form-check-all'>
                                @php $srno = 1; @endphp


                                @foreach ($ledgers as $ledger)
                                    <tr data-enter="{{ route('ledger.edit', $ledger->id) }}"
                                        data-delete="{{ route('ledger.edit', $ledger->id) }}">
                                        <td> {{ $srno++ }} </td>
                                        <td> {{ $ledger->name }}</td>
                                        <td>
                                            {{ isset($ledger->group->group_name) ? $ledger->group->group_name : '' }}
                                        </td>
                                        <td>
                                            {{ $ledger->mobile }}
                                        </td> 
                                        <td>
                                            {{ isset($ledger->godown->name) ? $ledger->godown->name : '' }}

                                        </td>
                                        <td>
                                            {{ $ledger->credit_limit }}
                                        </td>
                                        <td>
                                            {{ $ledger->opening_balance }}
                                        </td>
                                        <td>
                                            {{ $ledger->opening_bal_type }}
                                        </td>
                                           @if ($ledger->name != 'Aurangabad Sale A/c')
                                        @if (isset($access['Ledgers']) && $access['Ledgers']['update'] == '1')
                                            <td class="d-flex">
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('ledger.edit', $ledger->id) }}">Edit</a>
                                                <span style="margin-left: 3px;"></span> <!-- Adjust the margin as needed -->
                                                <form class="d-inline" action="{{ route('ledger.destroy', $ledger->id) }}"
                                                    method="post">
                                                    @csrf <!-- Include the CSRF token -->
                                                    @method('DELETE') <!-- Specify the DELETE method -->
                                                    <!-- Other form fields or hidden inputs if needed -->
                                                    <button class='btn btn-sm btn-danger' type='submit'>Delete</button>
                                                </form>
                                            </td>
                                        @endif
                                        @endif
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
