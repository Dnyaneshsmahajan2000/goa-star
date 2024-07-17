@extends('layouts.app',['title'=>'User Roles'])
@section('content')

<div class="row">
    <div class='col-lg-12'>
        <div class="card">
            <div class="card-header py-2">
                <div class="d-flex align-items-end ">
                    <h6 class="card-title flex-grow-1"></h6>
                    <div class="flex-shrink-0">
                        <a class="btn btn-primary btn-sm" href="{{route('role.create')}}">
                            <i class="ri-add-line "></i>
                            Add New User Role
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class='table-responsive'>
                    <table id='ledgertable' class='table table-sm table-bordered   table-hover bg-white'>
                        <thead class='bg-primary text-white'>
                            <tr>
                                <th>Sr.No</th>
                                <th>Name</th>
                                <th>Can Login</th>
                                
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody class='list form-check-all'>
                            @php $srno = 1; @endphp


                            @foreach ($user_roles as $role)
                            <tr>
                                <td> {{ $srno++ }} </td>
                                <td> {{ $role->name }}</td>
                                
                                <td>
                                   
                                    {{ $role->can_login == 1 ? 'Yes' : 'No' }}
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="{{ route('role.edit',$role->id ) }}">Edit</a>

                                    <form class="d-inline" action="{{ route('role.destroy',$role->id) }}" method="post">
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
                            <lord-icon src='https://cdn.lordicon.com/msoeawqm.json' trigger='loop' colors='primary:#121331,secondary:#08a88a' style='width:75px;height:75px'></lord-icon>
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