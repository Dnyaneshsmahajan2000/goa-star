@extends('layouts.app', ['title' => 'Add New ' . $vch_type, 'sidebar' => 'sm', 'date_type' => '1'])
@section('content')
    <div class="card">
        <div class="card-header p-2 bg-primary ">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="mb-sm-0 text-white">ADD NEW {{ $vch_type }}</h6>
                <div class="page-title-right">
                    <a title="Alt + A" id='view-all-button' href='{{ @route('vch.pr.index', ['vch_type' => $vch_type]) }}'
                        class=" btn btn-sm btn-light">
                        View All
                    </a>
                </div>


            </div>
        </div>

        <div class="card-footer">

            <div class="row gx-5 ">
                <div class="col-md-12">

                    <form method="POST"
                        action="{{ route('vch.pr.update', ['vch_type' => $vch_type, 'voucher' => $vch_no]) }}"  class="needs-validation" novalidate
                        >                   
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-xxl-2 col-md-3">
                                <label for="invoicenoInput">Bank</label>
                                <select name="bank_id" id="bank_id" class="form-control form-select form-select-sm">
                                    @foreach ($banks as $bank)
                                        <option
                                            value="{{ $bank['id'] }}"{{ isset($voucher['from']) && $voucher['from'] == $bank['id'] ? 'selected' : '' }}>
                                            {{ $bank['name'] }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xxl-10 col-md-10">

                            </div>
                            <br>
                            <hr>
                            <div class="col-md-4">
                                <label for="name">Party</label>
                                <input type="hidden" class="form-control form-control-sm" name="ledger_id"
                                    id="ledger_id" value="{{ $voucher['ledger_id'] }}">
                                <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{ $voucher->parties->name}}"
                                    required autofocus style="text-transform:capitalize">
                            </div>
                            <div class="col-md-2">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control form-control-sm" name="amount"
                                    value="{{ $voucher['amount'] }}" id="amount" required>
                            </div>
                            <div class="col-md-2">
                                <label for="mode">Mode</label>
                                <select name="mode" id="mode" class="form-control form-select form-select-sm">
                                    @foreach ($modes as $mode)
                                        <option value="{{ $mode->id }}" {{ isset($voucher->mode) && $voucher->mode == $mode->value ? 'selected' : '' }}> {{ $mode->value }} </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="details">Narration</label>
                                <input type="text" class="form-control form-control-sm" name="details" id="details" value="{{$voucher['details']}}">
                            </div>
                            <div class="col-md-1
                                    mt-3">
                                <button type="submit" class="btn btn-success w-100">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>


    </div>

    <script>
        $(document).ready(function() {
            var parties = @json($parties);
            $("#name").autocomplete({
                source: parties,
                select: function(event, ui) {
                    $('#ledger_id').val(ui.item.id);
                    $('#name').val(ui.item.label);
                    $('#amount').focus();
                }
            });
        });
    </script>
@endsection
