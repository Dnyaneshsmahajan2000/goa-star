@extends('layouts.app', ['title' => 'Verfiy Employee Expenses'])
@section('content')

    <div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class="card-header p-2 bg-primary ">
                    <div class="d-sm-flex align-items-end">
                        <h6 class="card-title flex-grow-1"></h6>
                        <div class="flex-shrink-0"> 
                            <a class="btn btn-primary btn-sm btn-light" href='{{ @route('emp-expenses.index') }}'
                                class=" btn btn-sm btn-primary text-white">
                                View All Expenses
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class='card-body'>
                    <div class='table-responsive'>
                        <table class='table table-striped align-middle table-nowrap' id='customerTable'>
                            <thead class='bg-primary text-white'>
                                <tr>
                                    <th>Sr.No</th>
                                    <th class='sort' data-sort='email'>Date</th>
                                    <th class='sort' data-sort='phone'>Amount</th>
                                    <th class='sort' data-sort='type'>Details</th>
                                    {{-- 
                                    <th class='sort' data-sort='type'>File</th> --}}
                                    <th class='sort' data-sort='action'>Action</th>
                                </tr>
                            </thead>
                            <tbody class='list form-check-all'>
                                <tr>
                                    <?php
                                    $c = 1;
                                     foreach ($employeeExpenses as $exp) {
                                       echo '<th>' . $c++ . '</th>';
                                    ?>


                                    <td>{{ $exp->date }}</td>
                                    <td>{{ $exp->amount }}</td>
                                    <td>{{ $exp->details ?? '' }}</td>



                                    <td>

                                        <a class='btn btn-sm btn-primary'
                                            href="{{ route('Employee_Expenses.verify_employee_expense', ['id' => $exp->id]) }}">Verify
                                            Expense</a>
                                        </a>

                                    </td>

                                </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                        <div class='noresult' style='display: none'>
                            <div class='text-center'>
                                <lord-icon src='https://cdn.lordicon.com/msoeawqm.json' trigger='loop'
                                    colors='primary:#121331,secondary:#08a88a' style='width:75px;height:75px'></lord-icon>
                                <h5 class='mt-2'>Sorry! No Result Found</h5>
                                <p class='text-muted mb-0'>We've searched more than 150+ Orders We did not find any orders
                                    for you search.</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
@stop
