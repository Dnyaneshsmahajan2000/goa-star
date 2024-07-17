<table id="" class="table table-bordered table-sm" style="   width: 100%;">
    <thead>
        <tr>
            @php
                $width = '100px';
            @endphp
            <th>Description of Goods</th>
            <th style="width: {{ $width }};">Qty</th>
            <th style="width: {{ $width }};">Wastage</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $item_list = session()->get('vchmfg_items');
        $total_qty = 0;
        ?>

        @isset($item_list)

            @foreach ($item_list as $key => $value)
                <?php
                
                $qty = $value['quantity'];
                $waste = $value['waste'];
                $total_qty += $qty;
                // $total_waste += $waste;
                $item = \App\Models\Item::find($value['item_id']);
                ?>
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $qty }}</td>
                    <td>{{ $waste }}</td>

                </tr>
            @endforeach
            <tr>
                <th class='h2 text-center'>Total</th>
                <th class='text-danger '>{{ $total_qty }}</th>
                {{-- <th class='text-danger '>{{ $total_waste }}</th> --}}

            </tr>
        @else
            <tr>
                <td colspan="3">No Data Found</td>
            </tr>
        @endisset

    </tbody>
    <tfoot>
        <tr>
            <td colspan="10">
                <input type="button" name="save" value="Save" onclick="order_submit()"
                    class="btn btn-primary w-100 btn-block mb-4 mt-4">
            </td>
        </tr>
    </tfoot>
</table>
