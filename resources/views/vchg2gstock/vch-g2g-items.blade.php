<table id="" class="table table-bordered table-sm" style="   width: 100%;">
    <thead >
        <tr>
            @php
                $width = '400px';
            @endphp
            <th>Description of Goods</th>
            <th  style="width: {{ $width }};">Qty</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
        
        $item_list = session()->get('vchg2g_items');
        $total_qty=0;
?>

        @isset($item_list)

            @foreach ($item_list as $key => $value)
                
                <?php
                $item=\App\Models\Item::find($value['item_id']);
                $qty = $value['quantity'];
                $total_qty += $qty;
                
                ?>
                <tr>
                    <td>{{ $item->name}}</td>
                    <td>{{ $qty }}</td>
                    
                </tr>
            @endforeach
            <tr>
                <th class='h2 text-center'>Total</th>
                <th class='text-danger '>{{ $total_qty }}</th>
               
            </tr>
        @else
            <tr>
                <td colspan="2">No Data Found</td>
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
<script></script>


    