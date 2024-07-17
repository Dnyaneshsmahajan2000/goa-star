@extends('layouts.app', ['title' => 'Machines'])
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
                            <a class="btn btn-primary btn-sm btn-light" title="Alt + A" id='view-all-button'
                                href="{{ route('machine.create') }}" class=" btn btn-sm btn-primary text-white">
                                Add New Machine
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
                                    <th>Name</th>
                                    <th>Under</th>
                                    @if (isset($access['Machines']) && $access['Machines']['update'] == '1')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class='list form-check-all'>
                                @php $srno = 1; @endphp


                                @foreach ($machines as $machine)
                                    <tr>
                                        <td> {{ $srno++ }} </td>
                                        <td> {{ $machine->name }}</td>
                                        <td>
                                            {{ $machine->details }}
                                        </td>
                                        @if (isset($access['Machines']) && $access['Machines']['update'] == '1')
                                            <td>
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('machine.edit', $machine->id) }}">Edit</a>

                                                <form class="d-inline" action="{{ route('machine.destroy', $machine->id) }}"
                                                    method="post">
                                                    @csrf <!-- Include the CSRF token -->
                                                    @method('DELETE') <!-- Specify the DELETE method -->
                                                    <!-- Other form fields or hidden inputs if needed -->
                                                    <button class='btn btn-sm btn-danger' type='submit'>Delete</button>
                                                </form>



                                            </td>
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
