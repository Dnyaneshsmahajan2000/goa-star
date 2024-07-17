@extends('layouts.app', ['title' => 'Manufacturing  '])
@section('content')
    <div class="card">
        <div class="card-header p-2 bg-primary">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="mb-sm-0 text-white"> Manufacturing </h6>
                <div class="page-title-right">
                    <a title="Alt + A" id='view-all-button' href='{{ route('vchmfg.create') }}'
                        class="btn btn-sm btn-light">
                        Add Manufacturing
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table id='ledgertable' class='table table-sm table-bordered table-hover bg-white'>
                    <thead class='bg-primary text-white'>
                        <tr>
                            <th>Sr.No</th>
                            <th>Date</th>
                            <th>Particular</th>
                            <th>Godown</th>
                            <th>Machine</th>
                            <th>Start Reading</th>
                            <th>End Reading</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class='list form-check-all'>
                        @php $srno = 1; @endphp

                        {{-- {{ $vchmfgs }} --}}
                        @foreach ($vchmfgs as $vch)
                            <tr>
                                <td>{{ $srno++ }}</td>
                                <td>{{ date('d-m-Y',strtotime($vch->date)) }}</td>
                              
                                <td>
                                    
                                    <ul>
                                        @foreach ($vch->vchMfgItem as $item)
                                            <li>{{ $item->item->name }} X {{ $item['quantity'] }} </li>
                                        
                                        @endforeach
                                    </ul>
                                </td>

                                <td>{{ $vch->godown->name}}</td>
                                <td>{{ $vch->machine->name}}</td>
                                <td>{{ $vch->start_reading}}</td>
                                <td>{{ $vch->end_reading}}</td>
                               
                                <td>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('vchmfg.edit', [$vch->id]) }}">Edit</a>
                                       <form class="d-inline" action="{{ route('vchmfg.destroy', $vch->id) }}"
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
