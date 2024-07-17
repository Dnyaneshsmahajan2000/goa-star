@extends('layouts.app', ['title' => 'Add New ' . $vch_type, 'sidebar' => 'sm', 'date_type' => '1'])
@section('content')
    <?php
    
    ?>
    <div class="card">
        <div class="card-header p-2 bg-primary ">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="mb-sm-0 text-white">ADD NEW {{ $vch_type }}</h6>
                <div class="page-title-right">
                    <a title="Alt + A" id='view-all-button' href='{{ @route('vch.gst.index', ['vch_type' => $vch_type]) }}'
                        class=" btn btn-sm btn-light">
                        View All groups
                    </a>
                </div>


            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('vch.update', ['vch_type' => $vch_type, 'voucher' => $id]) }}" id="fg-form"
                method="POST" class="needs-validation" novalidate>
                @method('PUT')
                @csrf <!-- CSRF token for security -->


                <div class="row g-2">
                    <div class="col-xxl-2 col-md-2">
                        <label for="date-field" class="form-label">Date</label>
                        <input type="date" class="form-control form-control-sm" id="date-field" data-provider="flatpickr"
                            data-time="true" placeholder="Select Date-time" value="{{ $voucher->date }}" name="date" />
                    </div>


                    <div class="col-xxl-2 col-md-2">
                        <label for="invoicenoInput">Ref. No</label>
                        <input type="text" class="form-control form-control-sm" id="invoicenoInput" autofocus
                            placeholder="Invoice No" name="ref_no" value='' />
                        <input type="hidden" class="form-control form-control-sm" name="grand_total" id="total_bill" />
                        <input type="hidden" class="form-control form-control-sm" name="gst_total" id="gst_total" />
                        <input type="hidden" class="form-control form-control-sm" name="total_amount" id="total_amount">

                    </div>
                    @if ($vch_type != 'order')
                        <div class="col-xxl-2 col-md-2">
                            <label for="invoicenoInput">Account</label>
                            <select name="account_id" id="account_id" class="form-control form-select form-select-sm">
                                @foreach ($accounts as $account)
                                    <option value="{{ $account['id'] }}"> {{ $account['name'] }} </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-xxl-2 col-md-2">
                        <label class="">Party <span id='credit_data'></span> <span
                                style="color: red; cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#exampleModalgrid">( Add Ledger )</span>
                        </label>
                        <input type="hidden" class="form-control form-control-sm" name="ledger_id" id="ledger_id"
                            value="{{ $voucher->ledger_id }}">
                        <input type="text" name="ledger_name" id="ledger_name" autofocus
                            class="form-control form-control-sm" value="{{ $voucher->ledger->name }}">


                    </div>
                    <div class="col-xxl-2 col-md-2">
                        <label for="godown_from">Godown</label>
                        <select class="form-control form-select form-select-sm" autofocus required=""
                            aria-label="Default select example" id="gd_id" name="gd_id">
                            <option value="">Select Godown</option>
                            @foreach ($godowns as $godown)
                                <option value="{{ $godown['id'] }}"
                                    {{ $voucher->godown_id == $godown['id'] ? 'selected' : '' }}>
                                    {{ $godown['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-xxl-2 col-md-2">
                        <div class="col-md-12">
                            <label for="invoicenoInput">Details</label>
                            <input type="text" class="form-control form-control-sm" id="details" placeholder="Details"
                                name="details" value="{{ $voucher->details }}">
                        </div>
                    </div>
                    {{--                 <input type="text" class="form-control" name="total_bill" id="total_bill">
                <input type="text" class="form-control" name="gst_total" id="gst_total">
 --}}
                    <input type="hidden" name="grand-final-total" id="grand-final-total" value="<?php //echo $grand_final_total;
                    ?>">
                    <!-- <input type="hidden" name="discount_per" id="discount_per" value="<?php //echo $discount_per;
                    ?>"> -->

                </div>
            </form>
        </div>
        <div class="card-footer">

            <div class="row gx-5 ">
                <div class="col-md-12">
                    <form method="post" action="" id="product_form">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Items</label>


                                <input type="hidden" class="form-control form-control-sm" name="item_id"
                                    id="item_id">
                                <input type="text" class="form-control form-control-sm" name="item_name"
                                    id="item_name" required="" autofocus style="text-transform:capitalize">


                            </div>



                            <div class="col-md-2">
                                <label>Quantity<span class="text-danger font-weight-bold">*</span></label>
                                <input type="number" class="form-control form-control-sm" name="quantity"
                                    id="quantity" required="" step="0.1">
                                <input type="hidden" class="form-control form-control-sm" name="gst" id="gst"
                                    required="" step="">

                            </div>

                            <div class="col-md-2">
                                <label>Rate<span class="text-danger font-weight-bold">*</span></label>
                                <input type="number" class="form-control form-control-sm" name="rate" id="rate"
                                    required="" step="0.1">
                            </div>
                            <div class="col-md-2">
                                <label>Discount(%)<span class="text-danger font-weight-bold">*</span></label>
                                <input type="number" class="form-control form-control-sm" name="discount"
                                    id="discount" value="0" required="" step="0.1">
                            </div>
                            <div class="col-md-2">
                                <label>Rate After Disc.<span class="text-danger font-weight-bold">*</span></label>
                                <input type="number" class="form-control form-control-sm" name="rate_after_discount"
                                    id="rate_after_discount" required="" step="0.01">
                            </div>


                            <div class="col-md-1 mt-3 ">
                                <button type="submit" id="item_add_btn" class="btn btn-success  w-100"
                                    name="quot_add">+ Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">

                <div class="table-responsive mt-2" id='item_list'>
                    @include('VchSalePurchase.vch-items')



                </div>
            </div>
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
                    $('#rate').val(ui.item.rate);
                    $('#gst').val(ui.item.gst_rate);
                    $("#quantity").val("1").select();
                    $("#rate_after_discount").val(ui.item.price);
                    $("#discount").val('0');


                }
            });

            var parties = @json($parties);
            $("#ledger_name").autocomplete({
                source: parties,
                select: function(event, ui) {
                    $('#ledger_id').val(ui.item.id);
                    $('#ledger_name').val(ui.item.label);
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
            var itemSelect = $('#item_name');
            var rateInput = $('#rate');
            var quantityInput = $('#quantity');
            var rate_after_discount_input = $('#rate_after_discount');
            var discountInput = $('#discount');
            var totalInput = $('#total');
            var gstInput = $('#gst'); // Add variable for GST input field

            rate_after_discount_input.on("keyup", function() {
                var rate_after_discount = rate_after_discount_input.val();
                var rate = rateInput.val();
                if (!isNaN(rate_after_discount && !isNaN(rate))) {
                    var discount = (((rate - rate_after_discount) / rate) * 100).toFixed(2);
                    discountInput.val(discount);
                }
            });

            discountInput.on("keyup", function() {
                var discount = discountInput.val();
                var rate = rateInput.val();
                if (!isNaN(discount && !isNaN(rate))) {
                    var rate_after_discount = (rate - (discount / 100 * rate)).toFixed(2);
                    rate_after_discount_input.val(rate_after_discount);
                }
            });


            $('#product_form').on('submit', function(event) {
                event.preventDefault();
                var item_id = itemId.val();
                var itemName = itemSelect.val();
                var itemRate = parseFloat(rateInput.val());
                var itemQuantity = parseFloat(quantityInput.val());
                var itemTotal = itemRate * itemQuantity;
                var itemDiscount = parseFloat(discountInput.val());
                var rate_after_discount = parseFloat(rate_after_discount_input.val());
                var gst = parseFloat(gstInput.val()); // Retrieve GST value
                //                var vch_gst = "gst";

                if (itemQuantity === 0) {
                    alert('Error: Item Quantity cannot be zero.');
                    return;
                }
                if (itemRate === 0) {
                    alert('Error: Rate cannot be zero.');
                    return;
                }
                if (rate_after_discount <= 0) {
                    alert('Error: Rate After Discount cannot be zero or negative.');
                    return;
                }

                var formData = {
                    item_id: item_id,
                    rate: itemRate,
                    quantity: itemQuantity,
                    total: itemTotal,
                    discount: itemDiscount,
                    rate_after_discount: rate_after_discount,
                    gst_rate: gst // Include GST in formData
                };

                $.ajax({
                    type: "get",
                    url: "{{ route('vch.item.create') }}",
                    data: formData,

                    success: function(result) {
                        $("#item_list").load('{{ route('vch.item.list', 'non_gst') }}');
                    },
                    error: function(result) {
                        console.log(result);
                    }
                });

                // Reset form fields and disable inputs
                itemSelect.val('');
                rateInput.val('');
                quantityInput.val('1');
                totalInput.val('0.00');
                discountInput.val('0');
                rate_after_discount_input.val('');
                gstInput.val(''); // Clear GST field
                itemSelect.focus();
            });


        });
    </script>
    <?php
    
    ?>

@endsection
