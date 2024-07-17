@extends('layouts.app', ['title' => 'Godown Wise Report'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('report.godownstock_report') }}" method="GET">
                        <div class="live-preview">
                            <div class="row gy-4">
                             <div class="col-xxl-3 col-md-3">
                                    <label for="godown_id">Select Godown:</label>
                                    <select class="form-select" id="godown_id" name="godown_id">
                                        @if (Auth::user()->role->name == 'SuperAdmin')
                                            <option value="All">All</option>
                                            @foreach ($godowns as $godown)
                                                <option value="{{ $godown['id'] }}"
                                                    @if (isset($voucher['godown_id']) && $voucher['godown_id'] == $godown['id']) selected @endif>
                                                    {{ $godown['name'] }}
                                                </option>
                                            @endforeach
                                        @else
                                            @foreach ($godowns as $godown)
                                                @if ($godown['id'] == Auth::user()->gd_id)
                                                    <option value="{{ $godown['id'] }}"
                                                        @if (isset($voucher['godown_id']) && $voucher['godown_id'] == $godown['id']) selected @endif>
                                                        {{ $godown['name'] }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-xxl-3 col-md-3">
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary">Generate Report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (isset($items))
        <?php
        $from_date = session('from_date');
        $to_date = session('to_date');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card p-2">
                    <div class="card-header text-center bg-primary text-white">
                        <h4 class="text-white">Godown Wise Stock Report</h4>
                        <h5 class="text-white" style="margin-top: 10px;">From Date:
                            {{ date('d-m-Y', strtotime($from_date)) }} - To Date: {{ date('d-m-Y', strtotime($to_date)) }}
                        </h5>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id='datatable' class='table table-sm table-bordered table-hover bg-white'>
                                <thead class="text-white bg-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Opening Stock</th>
                                        <th>Inward</th>
                                        <th>Outward</th>
                                        <th>Closing Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->name??'' }}</td>
                                            <td>{{ $item->get_opening_stock($gd_id) }}
                                            </td>
                                            <td>
                                                {{ $item->get_inward_stock($gd_id) }}
                                            </td>
                                            <td>
                                                {{ $item->get_outward_stock($gd_id) }}
                                            </td>
                                            <td>
                                                {{ $item->get_inward_stock($gd_id) + $item->get_outward_stock($gd_id) }}
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
