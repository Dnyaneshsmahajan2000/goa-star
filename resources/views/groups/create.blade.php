@extends('layouts.app',['title'=>'Add New Group'])
@section('content')
        <div class="card">
            <div class="card-header p-2 bg-primary ">
                <div class="d-sm-flex align-items-end">
                    <h6 class="card-title flex-grow-1"></h6>
                    <div class="flex-shrink-0">
                        <a class="btn btn-primary btn-sm btn-light" href='{{ @route('group.index') }}'
                            class=" btn btn-sm btn-primary text-white">
                            View All Groups
                        </a>
                    </div>
                </div>
            </div>
            
                <div class="card-body">

                    <form action="{{ route('group.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf <!-- CSRF token for security -->

                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-xxl-6 col-md-3">
                                    <div>
                                        <label for="placeholderInput" class="form-label">Group Name<span class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Name" required class="form-control form-control" id="group_name" name="group_name" value="" style="text-transform:capitalize">
                                    </div>
                                    @error('group_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xxl-4 col-md-3">
                                    <label for="godown_from" class="form-label">Under</label>
                                    <select class="model-select ignore form-control-sm  form-select" required="" aria-label="Default select example" id="parent_id" name="parent_id">
                                        <option value="" class="form-control form-control-sm form-select form-select-sm">Select Group</option>
                                        @foreach ($groups as $data)
                                            <option value="{{  $data['id']; }}">
                                                {{  $data['group_name']; }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-xxl-2 col-md-2 ">
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
   
@endsection