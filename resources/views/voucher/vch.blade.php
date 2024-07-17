@include('layout.header')
@include('layout.menubar')
<?php
$date = date('Y-m-d');
$ref_no = '';
$details = '';
$ledger_id = '';
$vch_no = '';
$ledger_name = '';
$discount_per = '';
$grand_final_total = '';
?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">
                        <?php
                        echo ucfirst($type);

                        ?>
                    </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">
                                <a title="Alt + A" id='view-all-button' href='vch-sale-purchase-all.php?type=<?php echo $type; ?>' class=" btn btn-sm btn-primary text-white">
                                    <i class=" align-bottom me-1"></i> View All
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        


        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gx-5">
                                <div class="col-md-12">

                                    <form id="fg-form" action="vch-sale-purchase-save.php" method="post">
                                        <div class="row gy-4">

                                            <input type='hidden' name='type' value='<?php echo $type; ?>'>
                                            <input type='hidden' name='action' value='<?php echo $action; ?>'>
                                            <input type='hidden' name='vch_no' value='<?php echo $id ?>'>

                                            <div class="col-xxl-2 col-md-2">
                                                <label for="date-field" class="">Date</label>
                                                <input type="date" class="form-control   form-control-sm" id="date-field" data-provider="flatpickr" data-time="true" placeholder="Select Date-time" value="<?php echo date('Y-m-d'); ?>" name="date" />
                                            </div>
                                            <?php
                                            if ($type != 'order') {
                                            ?>
                                                <div class="col-xxl-2 col-md-2">
                                                    <label for="invoicenoInput">Ref. No</label>
                                                    <input type="text" class="form-control form-control-sm" id="invoicenoInput" autofocus placeholder="Invoice No" name="ref_no" value='<?php echo $ref_no; ?>' />
                                                </div>
                                                <div class="col-xxl-2 col-md-2">
                                                    <label for="invoicenoInput">Account</label>
                                                    <select name="account_id" id="account_id" class="form-control form-select form-select-sm">
                                                        <?php
                                            //             if ($type == 'purchase' or $type == 'purchase_return') {
                                            //                 $account = get_ledgers(get_all_child_group_ids([PURCHASE_ACCOUNTS]));
                                            //             } else {
                                            //                 $account = get_ledgers(get_all_child_group_ids([SALES_ACCOUNTS]));
                                            //             }

                                            //             foreach ($account as $data) {
                                            //             ?>
                                            //                 <option value="<?php// echo $data['ledger_id'] ?>"><?php// echo $data['name'] ?></option>
                                            //             <?php } ?>
                                            //         </select>
                                            //     </div>
                                            // <?php //} ?>
                                            <div class="col-xxl-3 col-md-3">
                                                <label class="">Party <span id='credit_data'></span> <span style="color: red; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModalgrid">( Add Ledger )</span>
                                                </label>
                                                <input type="hidden" class="form-control form-control-sm" name="ledger_id" id="ledger_id" value="<?php echo $ledger_id; ?>">
                                                <input type="text" name="ledger_name" id="ledger_name" autofocus class="form-control form-control-sm" value="<?php echo $ledger_name; ?>">


                                            </div>


                                            <div class="col-xxl-3 col-md-3">
                                                <div class="col-md-12">
                                                    <label for="invoicenoInput">Details</label>
                                                    <input type="text" class="form-control form-control-sm" id="details" placeholder="Details" name="details" value="<?php //echo $details; ?>">
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" value=0 name="total" id="total_bill">
                                            <input type="hidden" class="form-control" value=0 name="gst_amt" id="gst_total">
                                            <input type="hidden" name="grand-final-total" id="grand-final-total" value="<?php //echo $grand_final_total; ?>">
                                            <!-- <input type="hidden" name="discount_per" id="discount_per" value="<?php //echo $discount_per; 
                                                                                                                    ?>"> -->

                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row gx-5 mt-2">
                                <div class="col-md-12">
                                    <form method="post" action="" id="product_form">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Items</label>


                                                <input type="hidden" class="form-control form-control-sm" name="r_id" id="r_id" required="">
                                                <input type="text" class="form-control form-control-sm" name="item_name" id="item_name" required="" autofocus style="text-transform:capitalize">


                                            </div>



                                            <div class="col-md-2">
                                                <label>Quantity<span class="text-danger font-weight-bold">*</span></label>
                                                <input type="number" class="form-control form-control-sm" name="quantity" id="quantity" required="" step="0.1">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Rate<span class="text-danger font-weight-bold">*</span></label>
                                                <input type="number" class="form-control form-control-sm" name="rate" id="rate" required="" step="0.1">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Discount(%)<span class="text-danger font-weight-bold">*</span></label>
                                                <input type="number" class="form-control form-control-sm" name="discount" id="discount" value="0" required="" step="0.1">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Rate After Disc.<span class="text-danger font-weight-bold">*</span></label>
                                                <input type="number" class="form-control form-control-sm" name="rate_after_discount" id="rate_after_discount" required="" step="0.01">
                                            </div>


                                            <div class="col-md-1 mt-3 ">
                                                <button type="submit" id="item_add_btn" class="btn btn-success  w-100" name="quot_add" disabled>+
                                                    Add</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div class="table-responsive mt-2" id='item_list'>
                                    @include('voucher.vch-items')
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>
@include('layout.footer')