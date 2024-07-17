<table id="" class="table table-bordered table-sm" style="   width: 100%;">
    <thead>
        <tr>
            @php
                $width = '100px';
            @endphp
            <th>Description of Goods</th>
            <th style="width: {{ $width }};">Qty</th>
            <th style="width: {{ $width }};">Rate</th>
            <th style="width: {{ $width }};">Disc. (%)</th>
            <th style="width: {{ $width }};">Rate-Disc</th>
            <th style="width: {{ $width }};">Total</th>
            <th style="width: {{ $width }};">GST (%)</th>
            <th style="width: {{ $width }};">GST Amt</th>
            <th style="width: {{ $width }};">Grand Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //total=rate * qty;
        $total = 0;
        $total_discount=0;
        $total_after_discount = 0;
        $total_cgst = 0;
        $total_sgst = 0;
        $total_igst = 0;
        $total_gst=0;
        $grand_total_bill=0;
        $grand_total_discount_amount=0;
        $total_gst_amt=0;
        $total_after_gst = 0;  //total after disc + total gst
        $total_qty = 0;
        $round_off=0;
        $final_total = 0;
        

        $item_list = session()->get('vch_items');
        
        
     ?>

        @isset($item_list)


            @foreach ($item_list as $key => $value)
                <?php
                
                $qty = $value['quantity'];
                $total_qty += $qty;
                
                $rate = $value['rate'];
                $discount = $value['discount'];
                $rate_after_discount = $value['rate_after_discount'];
                $gst = $value['gst-RATE'] ?? 0;
                $total_item = $rate * $qty;
                $discount_amount = $rate * $qty * ($discount / 100);
                $total_bill += $total_item;
                $total_item = $total_item - $discount_amount;
                $gst_amt = ($total_item * $gst) / 100;
                $total_gst_amt += $gst_amt;
                
                $grand_total_item = $total_item + $gst_amt;
                $grand_total_bill += $grand_total_item;
                $grand_total_discount_amount += $discount_amount;
                $total_cgst += $gst_amt / 2;
                $total_sgst += $gst_amt / 2;
                $item = \App\Models\Item::find($value['item_id']);
                ?>
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $qty }}</td>
                    <td>{{ $rate }}</td>
                    <td>{{ $discount }}</td>
                    <td>{{ $rate_after_discount }}</td>
                    <td>{{ $total_item }}</td>
                    <td>{{ $gst }}%</td>
                    <td>{{ $gst_amt }}</td>
                    <td>{{ $grand_total_item }}</td>
                </tr>
            @endforeach
            <tr>
                <th class='h2 text-center'>Total</th>
                <th class='text-danger '>{{ $total_qty }}</th>
                <th class='text-danger '></th>
                <th class='text-danger '></th>
                <th class='text-danger '></th>
                <th class='text-danger '>{{ $total }}</th>
                <th class='text-danger '></th>
                <th class='text-danger '>{{ $total_gst_amt }}</th>
                <th class='text-danger '>{{ $grand_total_bill }}</th>
            </tr>
        @else
            <tr>
                <td colspan="10">No Data Found</td>
            </tr>
        @endisset

        <?php
        $vch_items_data = [
            'total' => $total,
            'total_discount' => $grand_total_discount_amount,
            'total_gst_amt' => $total_gst_amt,
            'total_cgst_amount' => $total_cgst,
            'total_sgst_amount' => $total_sgst,
            'total_igst_amount' => $total_igst,
            'grand_total_after_tax' => $grand_total_bill,
        ];
        
        session()->put('vch_items_data', $vch_items_data);
        
        ?>
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
<script></script>

<script>
    $(document).ready(function() {

        $("#total_amount").val("{{ $total }}");

/*         $("#total_bill").val("{{ $grand_total_bill }}");
        $("#bill-total").html("{{ $grand_total_bill }}");
 */        $("#gst_total").val("{{ $total_gst_amt }}");
        $("#total-gst").html("{{ $total_gst_amt }}");

    });
</script>
