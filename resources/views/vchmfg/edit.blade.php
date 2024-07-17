@extends('layouts.app', ['title' => 'Manufacturing', 'sidebar' => 'sm', 'date_type' => '1'])
@section('content')
    <?php
    
    ?>
    <div class="card">
        <div class="card-header p-2 bg-primary ">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="mb-sm-0 text-white">Manufacturing</h6>
                <div class="page-title-right">
                    <a title="Alt + A" id='view-all-button' href='{{ @route('vchmfg.index') }}' class=" btn btn-sm btn-light">
                        View All
                    </a>
                </div>


            </div>
        </div>
        <div class="card-body">

            <?php
            //print_r(session()->all());
            ?>

            <form action="{{ route('vchmfg.update', ['vchmfg' => $id]) }}" id="fg-form" method="POST"
                class="needs-validation" novalidate>
                @method('PUT')
                @csrf <!-- CSRF token for security -->


                <div class="row g-2">


                    <div class="col-xxl-4 col-md-3">
                        <label for="exampleFormControlTextarea5" class="">Godown<span
                                class="text-danger font-weight-bold">*<a href="" style=color:red;>(Add
                                    Godown)</a></span></label>
                        <select class="form-control form-select form-select" autofocus required=""
                            aria-label="Default select example" id="godown_id" name="godown_id">
                            <option value="">Select Godown</option>
                            @foreach ($godowns as $godown)
                                <option value=" {{ $godown['id'] }}"
                                    {{ $vchmfg->godown_id == $godown['id'] ? 'selected' : '' }}>
                                    {{ $godown['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <div class="col-xxl-2 col-md-3">
                        <label for="exampleFormControlTextarea5" class="">Machines<span
                                class="text-danger font-weight-bold">*<a href="" style=color:red;>(Add
                                    Machine)</a></span></label>
                        <select class="form-select form-control" autofocus required=""
                            aria-label="Default select example" id="machine_id" name="machine_id">
                            <option value="">Select Machine</option>
                            @foreach ($machines as $machine)
                                <option value="{{ $machine->id }}"
                                    {{ $vchmfg->machine_id == $machine['id'] ? 'selected' : '' }}>
                                    {{ $machine->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-3">
                        <label for="payment_mode">Start Reading<span class="text-danger font-weight-bold">*</span></label>
                        <input type="text" class="form-control" name="start_reading" id="start_reading"
                            value="{{ old('start_reading', $vchmfg->start_reading) }}" required>
                    </div>
                    <input type="hidden" class="form-control" value=0 name="total" id="total_bill">
                    <div class="col-md-3">
                        <label for="payment_mode">End Reading<span class="text-danger font-weight-bold">*</span></label>
                        <input type="text" class="form-control" name="end_reading" id="end_reading"
                            value="{{ old('end_reading', $vchmfg->end_reading) }}" required>
                    </div>

                </div>
            </form>

            <div class="row gx-5 mt-4">
                <div class="col-md-12">
                    <form method="post" action="" id="product_form">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Finish Good <span class="text-danger font-weight-bold">*<a href=""
                                            style=color:red;>(Add
                                            Item)</a></span></label>


                                <input type="hidden" class="form-control" name="item_id" id="item_id" required="">
                                <input type="text" class="form-control" name="item_name" id="item_name"
                                    value="{{ old('item_name', '') }}" required="" autofocus
                                    style="text-transform:capitalize">


                            </div>



                            <div class="col-md-2">
                                <label>Quantity<span class="text-danger font-weight-bold">*</span></label>
                                <input type="text" class="form-control" name="quantity" id="quantity"
                                    value="{{ old('quantity', '') }}" required="">
                            </div>
                            <div class="col-md-2">
                                <label>Wastage(in kg)<span class="text-danger font-weight-bold">*</span></label>
                                <input type="text" class="form-control" name="waste" id="waste"
                                    value="{{ old('waste', '') }}" required="">
                            </div>


                            <div class="col-md-2 mt-3 ">
                                <button type="submit" id="item_add_btn" class="btn btn-success w-100" name="quot_add">+
                                    Add</button>
                            </div>

                        </div>
                        <!--end row-->
                </div>

            </div>

            <div class="col-md-12">

                <div class="table-responsive mt-2" id='item_list'>
                    @include('vchmfg.vch-mfg-items')

                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            var items = @json($items);

            $('#item_name').autocomplete({
                source: items,
                minLength: 1,
                autoFocus: true,

                select: function(event, ui) {

                    $('#item_id').val(ui.item.id);

                    $('#item_name').val(ui.item.label);
                    $("#quantity").val("1").select();
                    $("#waste").val("0").select();

                }
            });
        });
    </script>

    <script>
        function order_submit() {
            if (confirm("Are you sure want to save?")) {
                $("#fg-form").submit();
            }

        }
        $(document).ready(function() {
            var itemId = $('#item_id');
            var quantityInput = $('#quantity');
            var wasteInput = $('#waste');
            $('#product_form').on('submit', function(event) {
                event.preventDefault();
                var item_id = itemId.val();
                var itemQuantity = parseFloat(quantityInput.val());
                var itemWaste = parseFloat(wasteInput.val());

                if (itemQuantity === 0) {
                    alert('Error: Item Quantity cannot be zero.');
                    return;
                }

                var formData = {
                    item_id: item_id,
                    quantity: itemQuantity,
                    waste: itemWaste,
                };

                $.ajax({
                    type: "get",
                    url: "{{ route('vchmfg.item.create') }}",
                    data: formData,
                    success: function(result) {
                        $("#item_list").load('{{ route('vchmfg.item.list') }}');
                    },
                    error: function(result) {
                        console.log(result);
                    }
                });

                // Reset form fields and disable inputs
                itemSelect.val('');
                quantityInput.val('1');
                wasteInput.val('0');
                itemSelect.focus();
            });


        });
    </script>
    <?php
    
    ?>
@endsection
