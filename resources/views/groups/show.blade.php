@include('layout.header')
@include('layout.menubar')
<div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">ADD NEW</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">
                                    <a title="Alt + A" id='view-all-button' href='groups.php' class=" btn btn-sm btn-primary text-white">
                                        View All groups
                                    </a>

                                </li>
                            </ol>
                        </div>


                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                        <form action="group-save.php" method="POST" class="needs-validation" novalidate>

                            <div class="live-preview">
                                <div class="row gy-4">

                                    <div class="col-xxl-4 col-md-3">
                                        <div>
                                            <label for="placeholderInput" class="form-label">Group Name<span class="text-danger font-weight-bold">*</span></label>
                                            <input type="text" autofocus placeholder="Name" required class="form-control form-control-sm " id="group_name" name="group_name" value="" style="text-transform:capitalize">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-3">
                                        <label for="godown_from" class="form-label">Under</label>
                                        <select class="model-select ignore form-control-lg  form-select"  required="" aria-label="Default select example" id="parent_id" name="parent_id">
                                            <option value="" class="form-control form-select">Select Group</option>
                                            <?php /*foreach ($groups as $data) { ?>
                                                <option value="<?php echo $data['group_id']; ?>">
                                                    <?php echo $data['group_name']; ?>
                                                </option>
                                            <?php } */?>
                                        </select>
                                    </div>


                                    <div class="col-xxl-3 col-md-3 ">
                                        <div>
                                            <button type="submit" class="btn btn-primary mt-4 " value="submit" name="submit">Add Group</button>
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



    </div>
@include('layout.footer')