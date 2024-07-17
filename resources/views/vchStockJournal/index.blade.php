@extends('layouts.app', ['title' => 'Stock Journal'])
@section('content')
@php
    $permissions = Auth::user()->permission;
    $access = unserialize($permissions);
@endphp
    <div class="card">
        <div class="card-header p-2 bg-primary">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="mb-sm-0 text-white"> Stock Journal</h6>
                <div class="page-title-right">
                    <a title="Alt + A" id='view-all-button' href='{{ route('vchstockjournal.create') }}'
                        class="btn btn-sm btn-light">
                        Add Stock Journal
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
                            <th>Source</th>
                            <th>Destination</th>

                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class='list form-check-all'>
                        @php
                            $srno = 1;
                            $journal_data = [];
                        @endphp
                        @foreach ($stockJournal as $data)
                            <tr>
                                <td>{{ $srno++ }}</td>
                                <td>{{ $data->date }}</td>
                                <td>
                                    @php
                                        $total_amount = 0;
                                    @endphp <ul>
                                        @foreach ($data->VchStockJournalItems as $item)
                                            @if ($item['type'] == 'source')
                                                <li>
                                                    Item Name:
                                                    {{ $item->item_data->name }} <br>
                                                    Quantity:
                                                    {{ $item['quantity'] }} <br>
                                                </li>
                                            @endif
                                        @endforeach

                                    </ul>

                                </td>
                                <td>
                                    @php
                                        $journal_data = unserialize($data['stock_journal_data']);
                                        $total_amount = 0;
                                    @endphp <ul>
                                        @foreach ($data->VchStockJournalItems as $item)
                                            @if ($item['type'] == 'destination')
                                                <li>
                                                    Item Name:
                                                    {{ $item->item_data->name }}<br>
                                                    Quantity:
                                                    {{ $item['quantity'] }} <br>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                </td>
                                <td>{{ $data->details }}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('vchstockjournal.edit', [$data->id]) }}">Edit</a>
                                    <form class="d-inline" action="{{ route('vchstockjournal.destroy', [$data->id]) }}"
                                        method="post">
                                        @csrf <!-- Include the CSRF token -->
                                        @method('DELETE') <!-- Specify the DELETE method -->
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
