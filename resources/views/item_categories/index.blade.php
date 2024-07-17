@extends('layouts.app')
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
                            href="{{ route('item.category.create') }}" class=" btn btn-sm btn-primary text-white">
                            <i class="ri-add-line "></i>
                            Add New Category</a>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class='table-responsive'>
                    <table id='datatable' class='table table-sm table  table-hover bg-white'>
                        <thead class='bg-primary text-white'>
                            <tr>
                                <th>Sr.No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody class='list form-check-all'>
                            @php $srno = 1; @endphp


                            @foreach ($ItemCategory as $item)
                            <tr>
                                <td> {{ $srno++ }} </td>
                                <td> {{ $item->name }}</td>
                                <td>{{$item->description}}</td>
                               
                                <td>
                                    <a class="btn btn-sm btn-primary" href="{{ route('item.category.edit',$item->id ) }}">Edit</a>
                                    <a href="{{ route('item.category.show', $item->id) }}" class="btn btn-sm btn-secondary">Show</a>
                                    <form class="d-inline" action="{{ route('item.category.destroy',$item->id) }}" method="post">
                                        @csrf <!-- Include the CSRF token -->
                                        @method('DELETE') <!-- Specify the DELETE method -->
                                        <!-- Other form fields or hidden inputs if needed -->
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item category?')">Delete</button>

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