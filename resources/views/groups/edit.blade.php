@extends('layouts.app', ['title' => 'Update Group'])
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
            <form action="{{ @route('group.update', ['group' => $group->id]) }}" method="POST" class="needs-validation"
                novalidate>
                @csrf <!-- CSRF token for security -->
                @method('PUT') <!-- Use PUT method for update -->
                <div class="live-preview">
                    <div class="row gy-4">

                        <div class="col-xxl-4 col-md-3">
                            <div>
                                <label for="placeholderInput" class="form-label">Group Name<span
                                        class="text-danger font-weight-bold">*</span></label>
                                <input type="text" autofocus placeholder="Name" required class="form-control  "
                                    id="group_name" name="group_name" value="{{ $group['group_name'] }}"
                                    style="text-transform:capitalize">
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-3">
                            <label for="godown_from" class="form-label">Under</label>
                            <select class="form-control  form-select" required="" id="parent_id" name="parent_id">
                                <option value="0">Primary</option>

                                @foreach ($groups as $data)
                                    <option value="{{ $data['id'] }}" @if ($group['parent_id'] == $data['id']) selected @endif>
                                        {{ $data['group_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-xxl-3 col-md-3 ">
                            <div>
                                <button type="submit" class="btn btn-primary mt-4 " value="submit" name="submit">Update
                                    Group</button>
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
@endsection
