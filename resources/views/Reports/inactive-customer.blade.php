@extends('layouts.app', ['title' => 'Inactive Customer'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('report.inactivereport') }}" method="GET" class="needs-validation" novalidate>

                        <div class="live-preview">
                            <div class="row gy-4">
                                  <div class="col-xxl-3 col-md-3">
                                    <label for="type" class="form-label">Godowns</label>
                                    <select name="godown_id" id="godown_id" class="form-control form-select">
                                        @if (Auth::user()->role->name == 'SuperAdmin')
                                            <option value="All">All Godown</option>
                                        @endif
                                        @foreach ($godowns as $godown)
                                            <option value="{{ $godown['id'] }}">{{ $godown['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-3 col-md-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select name="type" id="type" class="form-control form-select">
                                        <option value="sale">Sale</option>
                                        <option value="order">Order</option>

                                    </select>
                                </div>
                                <div class="col-xxl-3 col-md-3">
                                    <label for="" class="form-label">Group</label>
                                    <select name="group_id" id="group_id" class="form-select">
                                        @foreach ($groups_data as $group)
                                            <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-2 col-md-2">
                                    <div>
                                        <button type="submit" class="btn btn-secondary btn-block mt-4"
                                            name="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php
            if(isset($ledgerIdArray)){

$from_date = session('from_date');
$to_date = session('to_date');
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-2">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="text-white">Inactive Customer Report</h4>
                    <h5 class="text-white" style="margin-top: 10px;">From Date: {{ date('d-m-Y', strtotime($from_date)) }} -
                        To Date: {{ date('d-m-Y', strtotime($to_date)) }}</h5>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Sr.No</th>
                                    <th class="sort" data-sort="customer_name">Name</th>
                                    <th class="sort" data-sort="mobile_no">Mobile Number</th>

                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($ledgerIdArray as $identifier)
                                    <?php
                                    $sr_no = 1;
                                    $ledger = \App\Models\Ledger::find($identifier['ledger_id']);

                                    ?>
                                    <tr>
                                        <td>{{ $sr_no++ }}</td>
                                        <td class="supplier">
                                            <a href="{{-- {{ route('ledger.view', ['ledger_id' => $ledgerId]) }} --}}">
                                                {{ $ledger->name }}
                                            </a>
                                        </td>
                                        <td class="user_name">{{ $ledger->mobile }}</td>
                                    </tr>
                                @endforeach
                            </tbody>


                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find
                                    any orders for you search.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- end col -->
    </div>
    <!-- end col -->
    </div>
    </div>
@endsection
