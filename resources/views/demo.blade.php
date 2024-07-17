@extends('layouts.app', ['title' => 'demo', 'date_type' => '2', 'side_bar' => 'lg'])
@section('content')

    <div class="row">
        <div class="col">

            <div class="card">
                <div class="card-header py-2">
                    <div class="d-flex align-items-end ">
                        <h6 class="card-title flex-grow-1">All Tasks</h6>
                        <div class="flex-shrink-0">
                            <button class="btn btn-danger btn-sm">
                                <i class="ri-add-line "></i>
                                View All
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    demo
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                        data-bs-target="#myModal">Standard Modal</button>
                    <button type="button" class="btn btn-primary" data-route="{{ route('home') }}" data-bs-toggle="modal"
                        data-bs-target="#myModal">Load Content for item.create</button>
                    <button type="button" class="btn btn-primary" data-route="item_group.create" data-bs-toggle="modal"
                        data-bs-target="#myModal">Load Content for item_group.create</button>
                    <button type="button" class="btn btn-primary" data-route="item.category.create" data-bs-toggle="modal"
                        data-bs-target="#myModal">Load Content for item.category.create</button>
                    <button type="button" class="btn btn-primary" data-route="item.unit.create" data-bs-toggle="modal"
                        data-bs-target="#myModal">Load Content for item.unit.create</button>


                </div>
            </div>

        </div> <!-- end col -->


    </div>


@stop
