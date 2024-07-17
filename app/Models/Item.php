<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'item_group_id',
        'item_category_id',
        'type',
        'unit',
        // 'weight',
        'rate',
        'gst_rate',
        // 'hsn_code',
        // 'opening_stock',
        'min_stock_qty',
        // 'maintain_stock',
        // 'item_barcode',
    ];

    public function itemgroups()
    {
        return $this->belongsTo(ItemGroup::class, 'item_group_id');
    }
    public function itemcategory()
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id');
    }
    public function boms()
    {
        return $this->hasMany(ItemBom::class, 'item_id');
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class, 'item_id');
    }
    public function get_stock_totals()
    {
        $from_date = session('from_date');
        $to_date = session('to_date');
        $ledger_ids = [$this->id];

        $stock_ob = stock::whereIn('gd_id', $ledger_ids)
            ->where('date', '<', $from_date)
            ->get();
        $outward = stock::whereIn('gd_id', $ledger_ids)
            ->whereBetween('date', [$from_date, $to_date])
            ->get();
        $inward = stock::whereIn('gd_id', $ledger_ids)
            ->whereIn('vch_type', ['sale', 'purchase_return'])
            ->whereBetween('date', [$from_date, $to_date])->get();
        $opening_stock = $stock_ob->sum('quantity');

        $inward = $inward->sum('quantity');
        $outward = $outward->sum('quantity');

        return ['inward' => $inward, 'outward' => $outward, 'opening_stock' => $opening_stock];
    }
    public function get_opening_stock($godownId)
    {
        $openingBalance = DB::table('stocks')
            ->where('date', '<', session('from_date'))
            ->where('item_id', $this->id);

        if ($godownId !== 'All') {
            $openingBalance->where('gd_id', $godownId);
        }

        $openingBalance = $openingBalance->sum('quantity');

        return $openingBalance;
    }

    public function get_inward_stock($godownId)
    {
        $inward = DB::table('stocks')
            ->where('date', '>=', session('from_date'))
            ->where('date', '<=', session('to_date'))
            ->where('quantity', '>', 0)
            ->where('item_id', $this->id);

        if ($godownId !== 'All') {
            $inward->where('gd_id', $godownId);
        }

        $inward = $inward->sum('quantity');

        return $inward;
    }
    public function get_outward_stock($godownId)
    {
        $outward = DB::table('stocks')
            ->where('date', '>=', session('from_date'))
            ->where('date', '<=', session('to_date'))
            ->where('quantity', '<', 0)
            ->where('item_id', $this->id);

        if ($godownId !== 'All') {
            $outward->where('gd_id', $godownId);
        }

        $outward = $outward->sum('quantity');

        return $outward;
    }
}
