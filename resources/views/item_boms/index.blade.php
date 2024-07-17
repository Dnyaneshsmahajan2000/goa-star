@extends('layouts.app', ['title' => 'Add New Item Bom'])
@section('content')
@php
$permissions = Auth::user()->permission;
$access = unserialize($permissions);
@endphp
    <div class="card">
        
        <div class="card-header p-2 bg-primary ">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="mb-sm-0 text-white">Bill Of Material</h6>
                <div class="page-title-right">
                    <a title="Alt + A" id='view-all-button' href='{{ @route('item.index') }}' class=" btn btn-sm btn-light">
                        Back
                    </a>
                </div>


            </div>
        </div>

        <div class='row'>
            <div class='col-lg-12'>
                <div class="card">
                    <div class="card-header m-0">
                        <div class="row gy-4">
                            <div class="col-xxl-4 col-md-3">
                                <label for="qty" class="form-label">Item Name :: {{ $item->name }}</label>

                            </div>
                            <div class="col-xxl-4 col-md-3">
                                <label for="qty" class="form-label">Rate :: {{ $item->rate }}</label>

                            </div>
                            <div class="col-xxl-4 col-md-3">
                                @if ($item->type == 'rm')
                                    <label for="qty" class="form-label">Type :: Raw Material</label>
                                @endif
                                @if ($item->type == 'fg')
                                    <label for="qty" class="form-label">Item Type :: Finish Good</label>
                                @endif
                            </div>

                        </div>

                    </div>
                    <div class="card-body mt-0 p-2">

                        <form action="{{ route('item.bom.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <div class="live-preview">
                                <div class="row">

                                    <input type="hidden" required id="item_id" name="item_id"
                                        value="{{ $item['id'] }}">
                                    <input type="hidden" placeholder="rm_id" required class=""
                                        id="rm_id" name="rm_id" value="{{ old('rm_id') }}">

                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="qty" class="form-label">Item Name<span
                                                    class="text-danger font-weight-bold">*</span></label>
                                            <input type="text" placeholder="item name" required class="form-control" autofocus
                                                id="item_name" name="item_name" value="{{ old('item_name') }}">
                                        </div>
                                        @error('item_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-xxl-4 col-md-4">
                                        <div>
                                            <label for="qty" class="form-label">Quantity<span
                                                    class="text-danger font-weight-bold">*</span></label>
                                            <input type="number" autofocus placeholder="Quantity" required
                                                class="form-control" id="qty" name="qty"
                                                value="{{ old('qty') }}">
                                        </div>
                                        @error('qty')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-xxl-4 col-md-3">
                                        <div>
                                            <label for="unit" class="form-label">Unit</label>
                                            <select class="form-control form-select" id="unit" name="unit"
                                                value="{{ old('unit') }}">
                                                <option value="">-- Select Unit --</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->unit_name }}">{{ $unit->unit_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('unit')
                                                <div class="text-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-md-1">
                                        <div>
                                            <button type="submit" class="btn btn-primary mt-4">Add</button>
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

        <!-- Index table for displaying item_bom data -->
        <div class='row'>
            <div class='col-lg-12'>
                <div class="card">
                    <div class="card-body">
                        {{-- <h5 class="card-title">Item Bom List</h5> --}}

                        <table class="table scrollable">
                            <thead style="vertical-align">
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Raw Material Name </th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $srno = 1;
                                ?>

                                @foreach ($item->boms as $item_bom)
                                    <tr>
                                        <td>{{ $srno++ }}</td>
                                        <td>{{ $item_bom->item->name }}</td>
                                        <td>{{ $item_bom->qty }}</td>
                                        <td>{{ $item_bom->unit }}</td>
                                        <td>
                                            <form action="{{ route('item.bom.delete', ['bom'=>$item_bom->id,'item_id'=>$item->id]) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- end card -->
            </div>
        </div>


        <script>
            $(document).ready(function() {
                var items = @json($items);

                $('#item_name').autocomplete({
                    source: items,
                    select: function(event, ui) {
                        $('#rm_id').val(ui.item.id);
                        $('#item_name').val(ui.item.label);
                        $("#qty").val("1").select();
                    }
                });
            });
        </script>

    @stop
