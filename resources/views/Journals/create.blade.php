@extends('layouts.app', ['title' => 'Journal', 'sidebar' => 'sm', 'date_type' => '1'])
@section('content')
    <?php
    
    ?>
    <div class="card">
        <div class="card-header p-2 bg-primary ">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="mb-sm-0 text-white"></h6>
                <div class="page-title-right">
                    <a title="Alt + A" id='view-all-button' href='{{ @route('vchjournal.index') }}' class=" btn btn-sm btn-light">
                        View All
                    </a>
                </div>


            </div>
        </div>
        <div class="card-body">

            <?php
            // print_r(session('date'));
            ?>

            <form action="{{ route('vchjournal.store') }}" id="fg-form" method="POST" class="needs-validation"
                novalidate>

                @csrf <!-- CSRF token for security -->


                <div class="row g-2">




                    {{-- <div class="col-xxl-3 col-md-4">
                        <label for="">Date</label>
                        <input type="date" class="form-control form-control-sm" name="" id="" value="session('date')">
                    </div> --}}

                    <div class="col-xxl-3 col-md-4">
                        <div class="col-md-12">
                            <label for="invoicenoInput">Details</label>
                            <input type="text" class="form-control form-control-sm" id="details" placeholder="Details"
                                name="details" value="<?php //echo $details;
                                ?>">
                        </div>
                    </div>


                </div>
            </form>
        </div>
        <div class="card-footer">

            <div class="row gx-5 ">
                <div class="col-md-12">
                    <form method="post" action="" id="product_form">
                        <div class="row">


                            <div class="col-md-4">
                                <label for="godown_from">Type</label>
                                <select class="form-control form-select form-select-sm" autofocus required=""
                                    aria-label="Default select example" id="type" name="type">
                                    <option value="">Select Type</option>
                                    <option value="source">By (to debit)</option>
                                    <option value="destination">To (to credit)</option>
                                    <option value="transfer">Contra</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Ledger</label>


                                <input type="hidden" class="form-control form-control-sm" name="ledger_id" id="ledger_id">
                                <input type="text" class="form-control form-control-sm" name="ledger_name" id="ledger_name"
                                    required="" autofocus style="text-transform:capitalize">


                            </div>


                            <div class="col-md-3">
                                <label>Amount<span class="text-danger font-weight-bold">*</span></label>
                                <input type="number" class="form-control form-control-sm" name="amount" id="amount"
                                    required="" step="0.1">

                            </div>



                            <div class="col-md-1 mt-3 ">
                                <button type="submit" id="item_add_btn" class="btn btn-success  w-100" name="">+
                                    Add</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                </div>
            </div>
            <div class="col-md-12">

                <div class="table-responsive mt-2" id='item_list'>
                    @include('Journals.vch-journal-data')

                </div>
            </div>
        </div>


    </div>

    </div>
    </div>
    <script>
        function order_submit() {
            if (confirm("Are you sure want to save?")) {
                $("#fg-form").submit();
            }

        }

        $(document).ready(function() {
            var ledgers = @json($ledgers);
            $("#name").autocomplete({
                source: ledgers,
                select: function(event, ui) {
                    $('#ledger_id').val(ui.item.id);
                    $('#ledger_name').val(ui.item.label);
                    $('#amount').focus();
                }
            });
        });

        $(document).ready(function() {
            var ledgers = @json($ledgers);

            $('#ledger_name').autocomplete({
                source: ledgers,
                minLength: 1,
                autoFocus: true,
                select: function(event, ui) {
                    $('#ledger_id').val(ui.item.id);
                    $('#ledger_name').val(ui.item.label);
                }
            });
            

            $('#product_form').on('submit', function(event) {
                event.preventDefault();
                var ledger_id = $('#ledger_id').val();
                var ledger_name = $('#ledger_name').val();
                var ledgerAmount = parseFloat($('#amount').val());
                var typeId = $('#type').val();

                var formData = {
                    ledger_id: ledger_id,
                    ledger_name: ledger_name,
                    amount: ledgerAmount,
                    type: typeId
                };


                $.ajax({
                    type: "get",
                    url: "{{ route('vchjournal.item.create') }}",
                    data: formData,
                    success: function(result) {

                        $("#item_list").load('{{ route('vchjournal.item.data') }}');

                        $('#ledger_id').val('');
                        $('#ledger_name').val('');
                        $('#amount').val('');
                        // $('#godown_id').val('');
                        $('#type').val('');
                        $('#type').focus();

0                    },
                    error: function(result) {
                        alert(result);
                    }
                });

            });
        });
    </script>
    
@endsection
