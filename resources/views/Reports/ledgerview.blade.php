@extends('layouts.app', ['title' => 'Ledger Report'])
@section('content')
    <?php
    $from_date = session('from_date');
    $to_date = session('to_date');
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-2">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="text-white">Ledger Of
                        <?php
                        $ledger = \App\Models\Ledger::find($ledger_id);
                        ?>
                        {{ $ledger->name }}

                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class='table table-hover table-bordered'>
                            <thead>
                                <tr>
                                    <th width="50">Date</th>
                                    <th width="10" style="text-align:center">Particulars</th>
                                    <th width="10" style="text-align:center">Vch No</th>
                                    <th width="10" style="text-align:center">Vch Type</th>
                                    <th width="10" style="text-align:center">Details</th>
                                    <th width="10" style="text-align:center">Debit</th>
                                    <th width="10" style="text-align:center">Credit</th>
                                </tr>
                            </thead>
                            @if (isset($opening_balance))
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="" class="text-center">
                                        <strong>Opening Balance:</strong>
                                    </td>

                                    @if ($openingBalance_debit > $openingBalance_credit)
                                        <td class="text-end">
                                            {{ $opening_balance }}
                                        </td>
                                        <td></td> <!-- Empty cell for alignment -->
                                    @else
                                        <td></td> <!-- Empty cell for alignment -->

                                        <td class="text-end">
                                            {{ $opening_balance }}
                                        </td>
                                    @endif

                                </tr>
                            @endif

                            <!-- Display Ledgers -->
                            @if (isset($ledgers) && count($ledgers) > 0)
                                @php
                                    $grand_total_debit = 0;
                                    $grand_total_credit = 0;
                                @endphp
                                @foreach ($ledgers as $ledger)
                                    @php
                                        $total_debit = $ledger->debit;
                                        $total_credit = $ledger->credit;
                                        $paymentReceipt = $ledger->paymentReceipt; // Using the relationship method
                                        $gstSalePurchase = $ledger->gstSalePurchase; // Using the relationship method for fallback

                                        $items = DB::table('vch_gst_sale_purchase_items')
                                            ->where('vch_id', $ledger['vch_no'])
                                            ->get();
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $ledger->date }}</td>
                                        <td>
                                            <ul>
                                                <h6>{{ $ledger->particular }}</h6>
                                                @foreach ($items as $item)
                                                    @php
                                                        $item_data = \App\Models\Item::find($item->item_id);
                                                    @endphp
                                                    <li>{{ $item_data->name }} X {{ $item->quantity }} piece x
                                                        {{ $item->rate_after_discount }} = {{ $item->total_after_disc }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="text-center">{{ $ledger->vch_no }}</td>
                                        <td class="text-center">{{ $ledger->vch_type }}</td>
                                        <td class="text-center">
                                            @if ($paymentReceipt)
                                                {{ $paymentReceipt->details }}
                                            @elseif($gstSalePurchase)
                                                {{ $gstSalePurchase->details }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="text-end">{{ $total_debit }}</td>
                                        <td class="text-end">{{ $total_credit }}</td>

                                    </tr>
                                    @php
                                        $grand_total_debit += $total_debit;
                                        $grand_total_credit += $total_credit;
                                    @endphp
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">No data available</td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Grand Total</strong></td>
                                    <td class="text-end">{{ $grand_total_debit }}</td>
                                    <td class="text-end">{{ $grand_total_credit }}</td>
                                </tr>
                                <!-- Display Closing Balance -->
                                @if (isset($closing_balance))
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Closing Balance:</strong></td>
                                        @if ($openingBalance_debit > $openingBalance_credit)
                                            <td class="text-end">{{ $closing_balance }}</td>
                                            <td></td> <!-- Empty cell for alignment -->
                                        @else
                                            <td></td> <!-- Empty cell for alignment -->
                                            <td class="text-end">{{ $closing_balance }}</td>
                                        @endif
                                    </tr>
                                @endif

                            </tfoot>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function submitForm(groupId) {
            // Set the value of the group_id field in the form
            document.getElementById('group_id').value = groupId;
            // Submit the form
            document.getElementById('report_form').submit();
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#table-33").dataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Item Stock Report'
                }, 'print'],
                "pageLength": 50,
                "bPaginate": false,
                "ordering": false
            });
        });
    </script>

    <script>
        $("#from_date").datepicker({
            dateFormat: "dd-mm-yy"
        }).datepicker("setDate", "today");
        $("#to_date").datepicker({
            dateFormat: "dd-mm-yy"
        }).datepicker("setDate", "today");
    </script>
@endpush
