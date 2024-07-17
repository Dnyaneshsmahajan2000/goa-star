<div class="modal fade xl-modal" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel"
    aria-modal="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel">Ledger Add</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="ledger-add">
                    <div class="live-preview">
                        <div class="row gy-4">

                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">Ledger Name<span
                                            class="text-danger font-weight-bold">*</span></label>
                                    <input type="text" placeholder="Ledger Name" required
                                        class="form-control form-control-sm " id="name" name="name"
                                        value="" style="text-transform:capitalize">
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <label for="exampleFormControlTextarea5">Group<span
                                        class="text-danger font-weight-bold">*</span></label>
                                <!--    <input type="hidden" class="form-control form-control" name="group_id" id="group_id">
                                                                          <input type="text" class="form-control form-control" required name="group_name" id="group_name_search" value=""> -->
                                <select name="group_id" class="form-control form-select form-select-sm" id="group_id"
                                    required>
                                    <option value="">Select Group</option>
                                    <?php foreach ($groups as $group) {
                                    ?>
                                    <option value="<?php echo $group['group_id']; ?>">
                                        <?php echo $group['group_name']; ?>
                                    </option>
                                    <?php  } ?>
                                </select>

                            </div>

                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">Mobile No</label>
                                    <input type="text" placeholder="Mobile No" class="form-control form-control-sm "
                                        id="mobile_no" name="mobile_no" value="" required>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">GST No</label>
                                    <input type="text" class="form-control form-control-sm" id="gst_no"
                                        name="gst_no" placeholder="GST No">
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">Address</label>
                                    <input type="text" placeholder="Address" class="form-control form-control-sm "
                                        id="address" name="address" value="" style="text-transform:capitalize">
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">City</label>
                                    <input type="text" placeholder="City" class="form-control form-control-sm"
                                        id="city" name="city" value="" style="text-transform:capitalize">
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">Pin Code</label>
                                    <input type="number" placeholder="Pin Code" class="form-control form-control-sm "
                                        id="pincode" name="pincode" value="">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">State<span
                                            class="text-danger font-weight-bold">*</span></label>
                                    <select id="state" class="form-control form-select form-select-sm"
                                        name="state" required placeholder="State">
                                        <?php include './state.php'; ?>
                                        <script>
                                            $("#state > option").filter(function() {
                                                return ($(this).val() == 'Maharashtra-27'); //To select Blue
                                            }).prop('selected', true);
                                        </script>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">Email Id</label>
                                    <input type="email" placeholder="Email" class="form-control form-control-sm "
                                        id="email_id" name="email_id" value="">
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">Bank Name</label>
                                    <input type="text" class="form-control form-control-sm" id="bank_name"
                                        name="bank_name" placeholder="Bank Name" style="text-transform:capitalize">
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">Account No</label>
                                    <input type="text" class="form-control form-control-sm" id="account_no"
                                        name="account_no" placeholder="Account No">
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">IFCS Code</label>
                                    <input type="text" class="form-control form-control-sm" id="ifsc_code"
                                        name="ifsc_code" placeholder="IFCS Code">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <label for="godown_from">Godown</label>
                                <select class="form-select form-select-sm" autofocus required=""
                                    aria-label="Default select example" id="gd_id" name="gd_id">
                                    <option value="">Select Godown</option>
                                    <option value="All" <?php echo $_SESSION['user']['gd_id'] === 'All' ? 'selected' : ''; ?>>All</option>
                                    <?php foreach ($godowns as $data) { ?>
                                    <option value="<?php echo $data['gd_id']; ?>" <?php echo $_SESSION['user']['gd_id'] === $data['gd_id'] ? 'selected' : ''; ?>>
                                        <?php echo $data['name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>



                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">Opening Balance</label>
                                    <input type="text" class="form-control form-control-sm" required
                                        id="opening_balance" value="0" name="opening_balance"
                                        placeholder="Opening Balance">
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <label for="exampleFormControlTextarea5">Opening Balance Type
                                </label>
                                <select class="form-select form-select-sm" aria-label="Default select example"
                                    id="opening_bal_type" required name="opening_bal_type"
                                    style="text-transform:capitalize">
                                    <option value="">Select Type</option>
                                    <option value="credit">Credit</option>
                                    <option value="debit">Debit</option>
                                </select>
                            </div>

                            <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-12">
                                <div>
                                    <label for="placeholderInput">Credit Limit</label>
                                    <input type="text" class="form-control form-control-sm" id="credit_limit"
                                        value="0" name="credit_limit" placeholder="Credit Limit">
                                </div>
                            </div>


                            <div class="col-xxl-3 col-md-3">
                                <div>
                                    <button type="submit" class="btn btn-primary mt-3" value="submit"
                                        name="submit">Add Ledger</button>
                                </div>
                            </div>

                        </div>
                        <!--end row-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /******************************************************************************** */ -->
<div class="modal fade" id="dateRangeModal" tabindex="-1" role="dialog" aria-labelledby="dateRangeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateRangeModalLabel">Select Date Range</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Date inputs -->
                <div class="form-group">
                    <label for="fromDate">From Date:</label>
                    <input type="date" class="form-control" id="fromDate">
                </div>
                <div class="form-group">
                    <label for="toDate">To Date:</label>
                    <input type="date" class="form-control" id="toDate">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveDateRange">Save</button>
            </div>
        </div>
    </div>
</div>
