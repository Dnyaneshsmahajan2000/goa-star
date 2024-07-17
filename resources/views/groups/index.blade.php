@extends('layouts.app', ['title' => 'Groups'])
@section('content')
    <!-- start page title -->
    @php
        $permissions = Auth::user()->permission;
        $access = unserialize($permissions);
    @endphp
    <div class="card">

        <div class="card-header p-2 bg-primary ">
            <div class="d-sm-flex align-items-end">
                <h6 class="card-title flex-grow-1"></h6>
                <div class="flex-shrink-0">
                    <a class="btn btn-primary btn-sm btn-light" href='{{ @route('group.create') }}'
                        class=" btn btn-sm btn-primary text-white">
                        <i class='ri-add-line align-bottom me-1'></i> Add New Group</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- end page title -->

            <div class='table-responsive'>
                <table id='datatable' class='table table-sm table-bordered   table-hover bg-white'>
                    <thead class='bg-primary text-white'>
                        <tr>
                            <th>Sr.No</th>
                            <th>Name</th>
                            <th>Under</th>
                            <th>Ledgers</th>
                            @if (isset($access['Groups']) && isset($access['Groups']['update']) && $access['Groups']['update'] == 1)
                                <th>Action</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody class='list form-check-all'>
                        @php $srno = 1; @endphp


                        @foreach ($groups as $row)
                            <tr>
                                <td> {{ $srno++ }} </td>
                                <td> {{ $row->group_name }}</td>
                                <td>
                                    @if ($row->parent)
                                        {{ $row->parent->group_name }}
                                    @else
                                        Primary
                                    @endif
                                </td>
                                <td>

                                    {{ count($row->ledgers) }}

                                </td>
                                @if (isset($access['Groups']) && $access['Groups']['update'] == '1')
                                    <td>
                                        @if ($row['level'] > '2')
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ route('group.edit', $row->id) }}">Edit</a>

                                            <form class="d-inline" action="{{ route('group.destroy', $row->id) }}"
                                                method="post">
                                                @csrf <!-- Include the CSRF token -->
                                                @method('DELETE') <!-- Specify the DELETE method -->
                                                <!-- Other form fields or hidden inputs if needed -->
                                                <button class='btn btn-sm btn-danger' type='submit'>Delete</button>
                                            </form>
                                        @endif

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
    <!-- end col -->
    </div>
@endsection
