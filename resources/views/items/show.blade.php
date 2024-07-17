@extends('layouts.app', ['title' => 'Show Item'])
@section('content')
    <div class='row'>
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-header p-2 bg-primary ">
                    <div class="d-sm-flex align-items-end">
                        <h6 class="card-title flex-grow-1"></h6>
                        <div class="flex-shrink-0">
                            <a class="btn btn-primary btn-sm btn-light" title="Alt + A" id='view-all-button'
                                href="{{ route('item.index') }}" class=" btn btn-sm btn-primary text-white">
                                View All Itema</a>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">

                    <form action="{{ route('item.show', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="live-preview">
                            <div class="row gy-4">

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="placeholderInput" class="form-label">Name<span
                                                class="text-danger font-weight-bold">*</span></label>
                                        <input type="text" autofocus placeholder="Name" required
                                            class="form-control form-control" id="name" name="name"
                                            value="{{ old('name', $item->name) }}" style="text-transform:capitalize">
                                    </div>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="item_group_id" class="form-label">Item Group</label>
                                        <select class="form-control " id="item_group_id" name="item_group_id">
                                            <option value="">-- Select Group --</option>
                                            @foreach ($itemgroups as $group)
                                            <option value="{{ $group->id }}"
                                                @if ($item->item_group_id == $group->id) selected @endif>
                                                {{ $group->name }}
                                            </option>
                                        @endforeach
                                            
                                        </select>
                                        @error('item_group_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="item_category_id" class="form-label">Item Category</label>
                                        <select class="form-control " id="item_category_id"
                                            name="item_category_id">
                                            <option value="">-- Select Category --</option>
                                            @foreach ($itemcategory as $Item)
                                                <option value="{{ $Item->id }}"
                                                    @if ($item->item_category_id == $Item->id) selected @endif>
                                                    {{ $Item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('item_category_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="type" class="form-label">Type</label>

                                        <select class="form-control " id="type" name="type">
                                            <option value="">-- Select type --</option>
                                            <option value="rm" @if ($item->type == 'rm') selected @endif>Raw
                                                Material</option>
                                            <option value="fg" @if ($item->type == 'fg') selected @endif>Finish
                                                Good</option>
                                        </select>


                                        @error('type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="is_bom" class="form-label">Is BOM</label>
                                        <select class="form-control " id="is_bom" name="is_bom">
                                            <option value="">-- Select type --</option>
                                            <option value="yes" @if ($item->is_bom == 'yes') selected @endif>Yes
                                            </option>
                                            <option value="no" @if ($item->is_bom == 'no') selected @endif>No
                                            </option>
                                        </select>
                                        @error('is_bom')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="unit" class="form-label">Unit</label>
                                        <select class="form-control " name="unit" id="unit">
                                            <option value="">-- Select Unit --</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->unit_name }}"
                                                    @if ($item->id == $unit->id) selected @endif>
                                                    {{ $unit->unit_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('unit')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="weight" class="form-label">Weight</label>
                                        <input type="text" class="form-control" id="weight" name="weight"
                                            value="{{ old('weight', $item->weight) }}">
                                        @error('weight')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="rate" class="form-label">Rate</label>
                                        <input type="text" class="form-control" id="rate" name="rate"
                                            value="{{ old('rate', $item->rate) }}">
                                        @error('rate')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="gst_rate" class="form-label">GST
                                            Rate</label>
                                        <input type="text" class="form-control" id="gst_rate" name="gst_rate"
                                            value="{{ old('gst_rate', $item->gst_rate) }}">
                                        @error('gst_rate')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="hsn_code" class="form-label">HSN
                                            Code</label>
                                        <input type="text" class="form-control" id="hsn_code" name="hsn_code"
                                            value="{{ old('hsn_code', $item->hsn_code) }}">
                                        @error('hsn_code')
                                            <div class="text-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="min_stock_qty" class="form-label">Minimum Stock
                                            Quantity</label>

                                        <input type="text" class="form-control" id="min_stock_qty"
                                            name="min_stock_qty"
                                            value="{{ old('min_stock_qty', $item->min_stock_qty) }}">
                                        @error('min_stock_qty')
                                            <div class="text-danger">
                                                {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="maintain_stock" class="form-label">Maintain Stock</label>
                                        <select class="form-control " id="maintain_stock"
                                            name="maintain_stock"
                                            value="{{ old('maintain_stock', $item->maintain_stock) }}">
                                            <option value="">-- Select One --</option>
                                            <option value="yes" @if ($item->maintain_stock == 'yes') selected @endif>Yes
                                            </option>
                                            <option value="no" @if ($item->maintain_stock == 'no') selected @endif>No
                                            </option>
                                        </select>
                                        @error('maintain_stock')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-3" id="opening_stock_container">
                                    <div>
                                        <label for="opening_stock" class="form-label">Opening Stock</label>
                                        <input type="text" class="form-control" id="opening_stock"
                                            name="opening_stock" value="{{ old('opening_stock', $item->opening_stock) }}"
                                            placeholder="Enter opening stock">
                                        @error('opening_stock')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <script>
                                    document.getElementById('maintain_stock').addEventListener('change', function() {
                                        var openingStockContainer = document.getElementById('opening_stock_container');
                                        if (this.value === 'yes') {
                                            openingStockContainer.style.display = 'block';
                                        } else {
                                            openingStockContainer.style.display = 'none';
                                        }
                                    });
                                </script>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="item_barcode" class="form-label">Item
                                            Barcode</label>
                                        <input type="text" class="form-control" id="item_barcode" name="item_barcode"
                                            value="{{ old('item_barcode', $item->item_barcode) }}">
                                        @error('item_barcode')
                                            <div class="text-danger">
                                                {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="discount" class="form-label">Discount</label>
                                        <input type="text" class="form-control" id="discount" name="discount"
                                            value="{{ old('discount', $item->discount) }}">
                                        @error('discount')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <label for="description" class="form-label">Description</label>
                                        <input class="form-control" id="description" name="description"
                                            value="{{ old('description', $item->description) }}">
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-xxl-4 col-md-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary">Update
                                            Item</button>
                                    </div>
                                </div> --}}
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputFields = document.querySelectorAll('input');
        inputFields.forEach(input => {
            input.disabled = true;
        });

        const selectFields = document.querySelectorAll('select');

        selectFields.forEach(select => {
            select.disabled = true;
        });
    });
</script>
