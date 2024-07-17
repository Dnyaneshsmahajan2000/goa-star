<div style="display: flex; justify-content: space-between;">
    <div style="width: 48%;">
        <table id="stock_journal_table" class="table table-bordered table-sm" style="width: 100%;">
            <thead>
                <tr>
                    <th colspan="3" style="text-align: center">Source</th>
                </tr>
                <tr>
                    <th>Ledger</th>
                    <th style="width: 200px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $item_list = session()->get('vch_journal_data');
                    $total_qty = 0;
                @endphp

                @if (isset($item_list['source']))
                    @foreach ($item_list['source'] as $key => $value)
                        @php
                            $ledger = \App\Models\Ledger::find($value['ledger_id']);
                            $qty = $value['amount'];
                            $total_qty += $qty;
                        @endphp
                        <tr>
                            <td>{{ $ledger->name }}</td>
                            <td>{{ $qty }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th class='h2 text-center'>Total</th>
                        <th class='text-danger' id="source_total">{{ $total_qty }}</th>
                    </tr>
                @else
                    <tr>
                        <td colspan="3">No Data Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div style="width: 48%;">
        <table id="destination_table" class="table table-bordered table-sm" style="width: 100%;">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center">Destination</th>
                </tr>
                <tr>
                    <th>To Ledgers</th>
                    <th style="width: 200px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($item_list['destination']))
                    @php
                        $total_qty2 = 0;
                    @endphp
                    @foreach ($item_list['destination'] as $key => $value)
                        @php
                            $ledger = \App\Models\Ledger::find($value['ledger_id']);
                            $qty = $value['amount'];
                            $total_qty2 += $qty;
                        @endphp
                        <tr>
                            <td>{{ $ledger->name }}</td>
                            <td>{{ $qty }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th class='h2 text-center'>Total</th>
                        <th class='text-danger' id="destination_total">{{ $total_qty2 }}</th>
                    </tr>
                @else
                    <tr>
                        <td colspan="3">No Data Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<tfoot>
    <tr>
        <td colspan="3">
            <input type="button" name="save" value="Save" onclick="order_submit()"
                class="btn btn-primary w-100 btn-block mb-4 mt-4">
        </td>
    </tr>
</tfoot>

<script>
function order_submit() {
    var sourceTotal = parseFloat(document.getElementById('source_total').innerText);
    var destinationTotal = parseFloat(document.getElementById('destination_total').innerText);

    if (sourceTotal === destinationTotal) {
        // Proceed with saving the form
        document.getElementById('fg-form').submit(); // Replace 'fg-form' with your form ID
    } else {
        alert('Source and Destination totals must be equal before saving.');
    }
}
</script>
