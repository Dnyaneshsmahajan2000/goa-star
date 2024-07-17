@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">

            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1"><br>
                                <h4 class="fs-16 mb-1">Hey, {{ @ucwords(Auth::user()->name) }} </h4>
                                <p class="text-muted mb-0">Here's what's happening with your company today.</p>
                            </div>
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
                @if (Auth::user()->role->name == 'Admin' || Auth::user()->role->name == 'SuperAdmin')

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-uppercase fw-medium text-muted mb-0">
                                            <a href="{{ route('report.order') }}" class="text-decoration-none"> Total
                                                Pending Order</a>
                                        </p>
                                    </div>

                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value" data-target="<?php echo round($count, 2);
                                            ?>">0</span>
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <lord-icon src="https://cdn.lordicon.com/qhviklyi.json" trigger="loop"
                                            colors="primary:#405189,secondary:#0ab39c" style="width: 55px; height: 55px">
                                        </lord-icon>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <div class="col-xl-3 col-md-6">

                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-uppercase fw-medium text-muted mb-0">
                                            <a href="{{ route('report.minstockqty.view') }}" class="text-decoration-none">Min
                                                Stock Finish
                                                Goods Items</a>
                                        </p>
                                    </div>

                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value" data-target="<?php echo round($item_count_FG, 2);
                                            ?>">0</span>
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <lord-icon src="https://cdn.lordicon.com/qhviklyi.json" trigger="loop"
                                            colors="primary:#405189,secondary:#0ab39c" style="width: 55px; height: 55px">
                                        </lord-icon>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body  -->
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-uppercase fw-medium text-muted mb-0">
                                            <a href="{{ route('report.inactivereport') }}" class="text-decoration-none">
                                                Total
                                                Inactive Customers</a>
                                        </p>
                                    </div>

                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value" data-target="<?php //echo round($inactive_ledgers_count, 2);
                                            ?>">0</span>
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <lord-icon src="https://cdn.lordicon.com/qhviklyi.json" trigger="loop"
                                            colors="primary:#405189,secondary:#0ab39c" style="width: 55px; height: 55px">
                                        </lord-icon>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-uppercase fw-medium text-muted mb-0">
                                            <a href="{{ route('report.payable.view') }}" class="text-decoration-none"> Total
                                                Payable</a>
                                        </p>
                                    </div>

                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            Rs.<span class="counter-value" data-target="<?php
                                            
                                            $total_balance_payable = abs($total_balance_payable);
                                            echo round($total_balance_payable, 2);
                                            ?>">0</span>
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <lord-icon src="https://cdn.lordicon.com/qhviklyi.json" trigger="loop"
                                            colors="primary:#405189,secondary:#0ab39c" style="width: 55px; height: 55px">
                                        </lord-icon>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-uppercase fw-medium text-muted mb-0">
                                            <a href="{{ route('report.receivable.view') }}" class="text-decoration-none"> Total
                                                receivable</a>
                                        </p>
                                    </div>

                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            Rs.<span class="counter-value" data-target="<?php
                                            $total_balance_receivable = abs($total_balance_receivable);
                                            echo round($total_balance_receivable, 2);
                                            ?>">0</span>
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <lord-icon src="https://cdn.lordicon.com/qhviklyi.json" trigger="loop"
                                            colors="primary:#405189,secondary:#0ab39c" style="width: 55px; height: 55px">
                                        </lord-icon>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>

                    <div class="col-xl-3 col-md-6">

                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-uppercase fw-medium text-muted mb-0">
                                            <a href="{{ route('report.minstockqty.view') }}"
                                                ordersummaryclass="text-decoration-none"> Min Stock Raw
                                                items</a>
                                        </p>
                                    </div>

                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <span class="counter-value" data-target="<?php echo round($item_count_RM, 2);
                                            ?>">0</span>
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <lord-icon src="https://cdn.lordicon.com/qhviklyi.json" trigger="loop"
                                            colors="primary:#405189,secondary:#0ab39c" style="width: 55px; height: 55px">
                                        </lord-icon>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body  -->
                        </div>
                    </div>
                    <!-- end col -->


                    <!-- end col -->

                    <div class="col-xl-3 col-md-6">

                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-uppercase fw-medium text-muted mb-0">
                                            <a href="{{ route('report.report30daysdebtors') }}"
                                                class="text-decoration-none"> Last 30 Days
                                                Customer</a>
                                        </p>
                                    </div>

                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            <?php echo "<span class='counter-value' data-target='" . round($customer_count, 2) . "'>0</span>";
                                            ?>
                                        </h4>
                                        <span class="badge bg-warning me-1"><?php //echo ;
                                        ?></span>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <lord-icon src="https://cdn.lordicon.com/qhviklyi.json" trigger="loop"
                                            colors="primary:#405189,secondary:#0ab39c" style="width: 55px; height: 55px">
                                        </lord-icon>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card  -->
                    </div>
                    <!-- end col -->

                    <!-- end col -->


                    <!-- end col -->

                </div> <!-- end .h-100-->
                                @endif

            </div> <!-- end col -->
        </div>
    </div>
@endsection
