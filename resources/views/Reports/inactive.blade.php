@extends('layouts.app', ['title' => 'Group Report'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('report.groupreport') }}" method="GET" class="needs-validation" novalidate>
                        @csrf
                        <div class="live-preview">
                            <div class="row gy-4">
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
    $from_date = session('from_date');
    $to_date = session('to_date');
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-2">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="text-white">Order Sale Difference Report</h4>
                    <h5 class="text-white" style="margin-top: 10px;">From Date: {{ date('d-m-Y', strtotime($from_date)) }} -
                        To Date: {{ date('d-m-Y', strtotime($to_date)) }}</h5>
                    </h4>
                </div>
            </div>
        @endsection
