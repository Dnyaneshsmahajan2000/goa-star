@extends('layouts.app', ['title' => 'Stock Journal', 'sidebar' => 'sm', 'date_type' => '1'])
@section('content')
    <?php
    $action; ?>
    <div class="card">
        <div class="card-header p-2 bg-primary ">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="mb-sm-0 text-white"></h6>
                <div class="page-title-right">
                    <a title="Alt + A" id='view-all-button' href='{{ @route('vchg2g.index') }}' class=" btn btn-sm btn-light">
                        View All
                    </a>
                </div>


            </div>
        </div>
        <div class="card-body">

            <div class="row gx-5 ">
                <div class="col-md-12">
                    <form method="post" action="" id="product_form">
                        <div class="row">


                            <div class="col-md-2">
                                <label for="godown_from">Type</label>
                                <select class="form-control form-select form-select-sm" autofocus required=""
                                    aria-label="Default select example" id="type" name="type">
                                    <option value="">Select Type</option>
                                    <option value="source">Source (Consumption)</option>
                                    <option value="destination">Destination (Production)</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>

                            <div class="col-md-2" id="from_godown_div" style="">
                                <label for="godown_from">From Godown</label>
                                <select class="form-control form-select form-select-sm" autofocus
                                    aria-label="Default select example" id="from_godown_id" name="from_godown_id">
                                    <option value="">Select Godown</option>
                                    @foreach ($godowns as $godown)
                                        <option value=" {{ $godown['id'] }}">{{ $godown['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2" id="to_godown_div">
                                <label for="godown_to">To Godown</label>
                                <select class="form-control form-select form-select-sm" autofocus
                                    aria-label="Default select example" id="to_godown_id" name="to_godown_id">
                                    <option value="">Select Godown</option>
                                    @foreach ($godowns as $godown)
                                        <option value=" {{ $godown['id'] }}">{{ $godown['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>




                            <div class="col-md-3">
                                <label>Items</label>


                                <input type="hidden" class="form-control form-control-sm" name="item_id" id="item_id">
                                <input type="text" class="form-control form-control-sm" name="item_name" id="item_name"
                                    required="" autofocus style="text-transform:capitalize">


                            </div>


                            <div class="col-md-2">
                                <label>Quantity<span class="text-danger font-weight-bold">*</span></label>
                                <input type="number" class="form-control form-control-sm" name="quantity" id="quantity"
                                    required="" step="0.1">

                            </div>



                            <div class="col-md-1 mt-3 ">
                                <button type="submit" id="item_add_btn" class="btn btn-success  w-100" name="">+
                                    Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">

                <div class="table-responsive mt-2" id='item_list'>
                    @include('vchStockJournal.vch-stock-journal-items')
                </div>
                <form action="{{ route('vchstockjournal.update',$id) }}" id="fg-form" method="POST" class="needs-validation"
                    novalidate>
                    @method('PUT')
                    @csrf <!-- CSRF token for security -->

                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Details</label>
                            <input type="text" class="form-control form-control-sm" name="details" id="details" value="{{ $VchStockJournal->details }}">
                        </div>
                        <div class="col-md-8">
                            <input type="button" name="save" value="Save" onclick="order_submit()"
                                class="btn btn-primary w-100 btn-block mb-4 mt-4">
                        </div>
                    </div>
                </form>

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
            var items = @json($items);

            $('#item_name').autocomplete({
                source: items,
                minLength: 1,
                autoFocus: true,
                select: function(event, ui) {
                    $('#item_id').val(ui.item.id);
                    $('#item_name').val(ui.item.label);
                }
            });

            $('#product_form').on('submit', function(event) {
                event.preventDefault();
                var item_id = $('#item_id').val();
                var item_name = $('#item_name').val();

                var itemQuantity = parseFloat($('#quantity').val());
                var to_godown_id = ($('#to_godown_id')) ? $('#to_godown_id').val() : 0;
                var from_godown_id = ($('#from_godown_id')) ? $('#from_godown_id').val() : 0;

                var typeId = $('#type').val();
                var formData = {
                    item_id: item_id,
                    item_name: item_name,
                    quantity: itemQuantity,
                    to_godown_id: to_godown_id,
                    from_godown_id: from_godown_id,
                    type: typeId,
                    action: 'edit'
                };


                $.ajax({
                    type: "get",
                    url: "{{ route('vchstockjournal.item.create') }}",
                    data: formData,
                    success: function(result) {

                        $("#item_list").load('{{ route('vchstockjournal.item.list') }}');
                        $('#item_id').val('');
                        $('#item_name').val('');
                        $('#quantity').val('');
                        $('#godown_id').val('');
                        $('#type').val('');
                        $('#type').focus();

                    },
                    error: function(result) {
                        alert(result);
                    }
                });

            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var typeSelect = document.getElementById("type");
            var fromGodownDiv = document.getElementById("from_godown_div");
            var toGodownDiv = document.getElementById("to_godown_div");

            typeSelect.addEventListener("change", function() {
                var selectedType = typeSelect.value;

                if (selectedType === "source") {
                    fromGodownDiv.style.display = "block";
                    toGodownDiv.style.display = "none";
                } else if (selectedType === "destination") {
                    fromGodownDiv.style.display = "none";
                    toGodownDiv.style.display = "block";
                } else if (selectedType === "transfer") {
                    fromGodownDiv.style.display = "block";
                    toGodownDiv.style.display = "block";
                } else {
                    fromGodownDiv.style.display = "none";
                    toGodownDiv.style.display = "none";
                }
            });
        });
    </script>
@endsection
