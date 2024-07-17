<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $fillable = [
        'group_name',
        'parent_id'
    ];

    public static function get_all_groups()
    {
        return static::where('is_enabled', 1)->get();
    }

    public function get_totals()
    {
        $ledgers = $this->getAllLedgers([$this->id]);
        $opening_balance = 0;
        $from_date = session('from_date');
        $to_date = session('to_date');
        $ledger_ids = []; // Initialize $ledger_ids array

        foreach ($ledgers as $ledger) {
            $ledger_ids[] = $ledger->id;
        }
        $transactions_ob = transaction::whereIn('ledger_id', $ledger_ids)
            ->where('date', '<', $from_date)
            ->get();
        $transactions = transaction::whereIn('ledger_id', $ledger_ids)
            ->whereBetween('date', [$from_date, $to_date])
            ->get();
        $opening_total_credit = $transactions_ob->sum('credit');
        $opening_total_debit = $transactions_ob->sum('debit');
        $opening_balance_cr = $opening_balance_dr = NULL;
        if ($opening_total_credit > $opening_total_debit) {
            $opening_balance_cr = $opening_total_credit - $opening_total_debit;
        } else {
            $opening_balance_dr = $opening_total_debit - $opening_total_credit;
        }
        $credit = $transactions->sum('credit');
        $debit = $transactions->sum('debit');

        return ['credit' => $credit, 'debit' => $debit, 'opening_cr' => $opening_balance_cr, 'opening_dr' => $opening_balance_dr];
        if (!empty($ledgers)) {

            $opening_balance = 0;
            $from_date = session('from_date');
            $to_date = session('to_date');

            $ledger_ids = []; // Initialize $ledger_ids array
            foreach ($ledgers as $ledger) {
                $ledger_ids[] = $ledger->id;
            }

            $transactions_ob = transaction::whereIn('ledger_id', $ledger_ids)
                ->where('date', '<', $from_date)
                ->get();
            $transactions = transaction::whereIn('ledger_id', $ledger_ids)
                ->whereBetween('date', [$from_date, $to_date])
                ->get();

            $opening_total_credit = $transactions_ob->sum('credit');
            $opening_total_debit = $transactions_ob->sum('debit');
            $opening_balance_cr = $opening_balance_dr = null;

            if ($opening_total_credit > $opening_total_debit) {
                $opening_balance_cr = $opening_total_credit - $opening_total_debit;
            } else {
                $opening_balance_dr = $opening_total_debit - $opening_total_credit;
            }

            $credit = $transactions->sum('credit');
            $debit = $transactions->sum('debit');

            return ['credit' => $credit, 'debit' => $debit, 'opening_cr' => $opening_balance_cr, 'opening_dr' => $opening_balance_dr];
        }
    }

    public function parent()
    {
        return $this->belongsTo(Group::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Group::class, 'parent_id');
    }

    public static function getAllLedgers(array $groupIds, $type = 'in')
    {
        $all_child_groups_ids = Group::getAllChildGroupIds($groupIds, true);
        if ($type == 'in') {
            return Ledger::whereIn('group_id', $all_child_groups_ids)->get();
        } else {
            return Ledger::whereNotIn('group_id', $all_child_groups_ids)->get();
        }
    }

    public static function getAllChildGroups(array $groupIds)
    {

        $all_child_groups_ids = Group::getAllChildGroupIds($groupIds);

        return Group::whereIn('id', $all_child_groups_ids)->get();
    }


    public static function getAllChildGroupIds(array $groupIds, $include_parent = false)
    {
        $allChildIds = $include_parent ? $groupIds : [];

        foreach ($groupIds as $parentId) {
            $childIds = Group::getAllChildIds($parentId);
            $allChildIds = array_merge($allChildIds, $childIds);
        }

        return $allChildIds;
    }

    protected static function getAllChildIds($parentId)
    {
        $childIds = [];
        $children = Group::where('parent_id', $parentId)->get();

        foreach ($children as $child) {
            $childIds[] = $child->id;
            $childIds = array_merge($childIds, Group::getAllChildIds($child->id));
        }

        return $childIds;
    }


    public function ledgers()
    {
        return $this->hasMany(Ledger::class, 'group_id');
    }
}
