<div style="display: flex; justify-content: space-between;">
    <div style="width: 48%;">
        <table id="stock_journal_table" class="table table-bordered table-sm" style="width: 100%;">
            <thead>
                <tr>
                    <th colspan="3" style="text-align: center">Source</th>
                </tr>
                <tr>
                    <th>Description of Goods</th>
                    <th style="width: 200px;">Godown</th>
                    <th style="width: 200px;">Qty</th>
                </tr>
            </thead>
            <tbody>

                @php
                    $item_list = session()->get('stock_journal_items');
                    $total_qty = 0;

                @endphp
                <?php //var_dump($item_list);
                ?>

                @if (isset($item_list['source']))
                    @foreach ($item_list['source'] as $key => $value)
                        @php
                            $item = \App\Models\Item::find($value['item_id']);
                            $from_godown_id = \App\Models\Godown::find($value['from_godown_id']);

                            $qty = $value['quantity'];
                            $total_qty += $qty;
                        @endphp
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $from_godown_id->name }} </td>
                            <td>{{ $qty }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th class='h2 text-center'>Total</th>
                        <th></th>
                        <th class='text-danger '>{{ $total_qty }}</th>
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
                    <th colspan="3" style="text-align: center">Destination</th>
                </tr>
                <tr>
                    <th>Description of Goods</th>
                    <th style="width: 200px;">Godown</th>
                    <th style="width: 200px;">Qty</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($item_list['destination']))
                    @php
                        $total_qty = 0;
                    @endphp
                    @foreach ($item_list['destination'] as $key => $value)
                        @php
                            $item = \App\Models\Item::find($value['item_id']);
                            $to_godown_id = \App\Models\Godown::find($value['to_godown_id']);
                            $qty = $value['quantity'];
                            $total_qty += $qty;
                        @endphp
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $to_godown_id->name }}</td>
                            <td>{{ $qty }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th class='h2 text-center'>Total</th>
                        <th></th>
                        <th class='text-danger '>{{ $total_qty }}</th>
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
        <td colspan="8" style="height: 200px; overflow-y: auto;">
        </td>
    </tr>
</tfoot>
