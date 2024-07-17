@extends('layouts.app',['title'=>'Update Company'])
@section('content')

    <div class='row'>
        <div class='col-lg-12'>
            <div class="card">
              
                
                <div class="card-body">

                    <form action="{{ route('company.update', $company->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf <!-- CSRF token for security -->
                        @method('PUT') <!-- Method spoofing for PUT request -->

                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="name" class="form-label">Company Name<span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Name" required class="form-control" id="company_name" name="company_name" value="{{ $company->company_name }}">
                                    </div>
                                    
                                </div>

                                

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="mobile" class="form-label">Mobile<span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Mobile" required class="form-control" id="mobile" name="mobile" value="{{ $company->mobile }}">
                                    </div>
                                    
                                </div>
                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" autofocus placeholder="Email" class="form-control" id="email" name="email" value="{{ $company->email }}">
                                    </div>
                                   
                                </div>


                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" autofocus placeholder="Address" class="form-control" id="address" name="address" value="{{ $company->address }}">
                                    </div>
                                    
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" autofocus placeholder="City" class="form-control" id="city" name="city" value="{{ $company->city }}">
                                    </div>
                                    
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="state" class="form-label">State<span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="State" required class="form-control" id="state" name="state" value="{{ $company->state }}">
                                    </div>
                                    
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="pincode" class="form-label">Pincode</label>
                                        <input type="text" autofocus placeholder="Pincode" class="form-control" id="pincode" name="pincode" value="{{ $company->pincode }}">
                                    </div>
                                    
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="logo" class="form-label">Logo</label>
                                        <input type="file" id="logo" name="logo">
                                    </div>
                                    
                                </div>
                                
                                

                               

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary mt-4" name="submit">Update Ledger</button>
                                    </div>
                                </div>

                            </div>
                            <!--end row-->
                        </div>
                    </form>

                </div>
            </div><!-- end card -->
        </div>
    </div>

@stop
