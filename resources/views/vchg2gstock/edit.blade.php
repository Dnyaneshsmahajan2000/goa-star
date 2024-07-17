@extends('layouts.app', ['title' => 'Update G2G Stock Transfer',  'sidebar' => 'sm', 'date_type' => '1'])
@section('content')

    <?php
    
    ?>
    <div class="card">
        <div class="card-header p-2 bg-primary ">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="mb-sm-0 text-white">Update G2G Stock Transfer</h6>
                <div class="page-title-right">
                    <a title="Alt + A" id='view-all-button' href='{{ @route('vchg2g.index') }}'
                        class=" btn btn-sm btn-light">
                        View All 
                    </a>
                </div>


            </div>
        </div>
        <div class="card-body">

            <?php
            //print_r(session()->all());
            ?>
           
            <form action="{{ route('vchg2g.update',['vchg2g'=>$id]) }}" id="fg-form" method="POST"
                class="needs-validation" novalidate>
                @method('PUT')
                @csrf <!-- CSRF token for security -->


                <div class="row g-2">
                    
                    
                    
                   
                    <div class="col-xxl-3 col-md-4">
                        <label for="godown_from">From Godown</label>
                        <select class="form-control form-select form-select-sm" autofocus required=""
                            aria-label="Default select example" id="godown_from" name="godown_from">
                            <option value="">Select Godown</option>
                            @foreach ($godowns as $godown)
                                <option value=" {{ $godown['id'] }}" 
                                {{ $vchg2g->godown_from == $godown['id'] ? 'selected' : '' }}>
                                    {{ $godown['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xxl-3 col-md-4">
                        <label for="godown_from">To Godown</label>
                        <select class="form-control form-select form-select-sm" autofocus required=""
                            aria-label="Default select example" id="godown_to" name="godown_to">
                            <option value="">Select Godown</option>
                            @foreach ($godowns as $godown)
                                <option value=" {{ $godown['id'] }}"
                                {{ $vchg2g->godown_to == $godown['id'] ? 'selected' : '' }}>
                                    {{ $godown['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-xxl-3 col-md-4">
                        <div class="col-md-12">
                            <label for="invoicenoInput">Details</label>
                            <input type="text" class="form-control form-control-sm" id="details" placeholder="Details"
                                name="details" value="<?php echo $vchg2g['details'];
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
                            <div class="col-md-6">
                                <label>Items</label>


                                <input type="hidden" class="form-control form-control-sm" name="item_id" id="item_id"
                                    >
                                <input type="text" class="form-control form-control-sm" name="item_name"
                                    id="item_name" required="" autofocus style="text-transform:capitalize">


                            </div>



                            <div class="col-md-3">
                                <label>Quantity<span class="text-danger font-weight-bold">*</span></label>
                                <input type="number" class="form-control form-control-sm" name="quantity"
                                    id="quantity" required="" step="0.1">
                                <input type="hidden" class="form-control form-control-sm" name="gst" id="gst"
                                    required="" step="">

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
                    @include('vchg2gstock.vch-g2g-items')



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
                    $("#quantity").val("1").select();
                 
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
            var quantityInput = $('#quantity');
          
            $('#product_form').on('submit', function(event) {
                event.preventDefault();
                var item_id = itemId.val();
                var itemName = itemSelect.val();
             
                var itemQuantity = parseFloat(quantityInput.val());
               
                // Validation checks
                if (itemQuantity === 0) {
                    alert('Error: Item Quantity cannot be zero.');
                    return;
                }

                var formData = {
                    item_id: item_id,
                    item_name: itemName,
                    quantity: itemQuantity
                };

                $.ajax({
                    type: "get",
                    url: "{{ route('vchg2g.item.create') }}",
                    data: formData,
                    success: function(result) {
                       
                        $("#item_list").load('{{ route('vchg2g.item.list') }}');
                    },
                    error: function(result) {
                        console.log(result);
                    }
                });

                // Reset form fields and disable inputs
                itemSelect.val('');
                quantityInput.val('1');
                itemSelect.focus();
            });


        });
    </script>
    <?php
    
    ?>

@endsection
