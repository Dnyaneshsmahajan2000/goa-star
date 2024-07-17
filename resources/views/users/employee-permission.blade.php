@extends('layouts.app', ['title' => 'Employee Attendance'])

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('user.permission_save', ['id' => $id]) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class='card-header'>
                        <h5 class='card-title'>
                            Set permissions for <b>
                                @php
                                    $user = \App\Models\User::find($id);

                                @endphp
                                {{ $user->name }}
                            </b>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle table-nowrap" id="customerTable">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Sr.No</th>
                                        <th class="sort" data-sort="email">Menu Name</th>
                                        <th class="sort" data-sort="phone">Add</th>
                                        <th class="sort" data-sort="type">Update/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $c = 1; @endphp
                                    @foreach ($access as $a => $v)
                                        <tr>
                                            <th>{{ $c++ }}</th>
                                            <td>{{ ucwords(str_replace('_', ' ', $a)) }}</td>
                                            <td>
                                                @php
                                                    $checkedAdd = '';
                                                    if (
                                                        isset($permissions[$a]) &&
                                                        isset($permissions[$a]['add']) &&
                                                        $permissions[$a]['add'] == 1
                                                    ) {
                                                        $checkedAdd = 'checked';
                                                    }
                                                @endphp
                                                <input type="hidden" name="access[{{ $a }}][add]"
                                                    value="0">
                                                <input type="checkbox" name="access[{{ $a }}][add]"
                                                    {{ $checkedAdd }} value="1" class="add-checkbox">
                                            </td>
                                            <td>
                                                @php
                                                    $checkedUpdate = '';
                                                    if (
                                                        isset($permissions[$a]) &&
                                                        isset($permissions[$a]['update']) &&
                                                        $permissions[$a]['update'] == 1
                                                    ) {
                                                        $checkedUpdate = 'checked';
                                                    }
                                                @endphp
                                                <input type="hidden" name="access[{{ $a }}][update]"
                                                    value="0">
                                                <input type="checkbox" name="access[{{ $a }}][update]"
                                                    {{ $checkedUpdate }} value="1" class="update-checkbox">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" onclick="toggleAllAdd()"> All
                                    Add</button>
                                <button type="button" class="btn btn-secondary" onclick="toggleAllUpdate()">All
                                    Update/Delete</button>
                            </div>

                            <div class="text-center  mt-3">
                                <button type="submit" class="btn btn-primary">Save Permission</button>
                            </div>

                        </div>
                    </div>

                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    </form>
    <!-- end form -->
    <div class="noresult" style="display: none">
        <div class="text-center">
            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
            <h5 class="mt-2">Sorry! No Result Found</h5>
            <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find
                any orders for you search.</p>
        </div>
    </div>

    <!-- end main-content -->

    <script>
        function markAll(status) {
            var radios = document.querySelectorAll('input[type="radio"]');
            for (var i = 0; i < radios.length; i++) {
                radios[i].checked = (radios[i].value === status);
            }
        }
    </script>
    <script>
        function toggleAllAdd() {
            const addCheckboxes = document.querySelectorAll('.add-checkbox');
            const allChecked = Array.from(addCheckboxes).every(checkbox => checkbox.checked);
            addCheckboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
        }

        function toggleAllUpdate() {
            const updateCheckboxes = document.querySelectorAll('.update-checkbox');
            const allChecked = Array.from(updateCheckboxes).every(checkbox => checkbox.checked);
            updateCheckboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
        }
    </script>
@endsection
