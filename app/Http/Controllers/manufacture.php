<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manufacturing; // Assuming your model is named Manufacturing
use App\Models\Item; // Assuming you have an Item model
use Database\Seeders\ManufacturingSeeder;

// class ManufacturingController extends Controller
// {
//     public function store(Request $request)
//     {
//         $admin = $request->session()->get('user');
//         $item_list = $request->session()->get('manufacture');

//         $date = date('Y-m-d', strtotime($request->date));
//         $mId = $request->m_id;
//         $startReading = $request->start_reading;
//         $endReading = $request->end_reading;
//         $gdId = $request->gd_id;

//         $manufacture = Manufacturing::create([
//             'date' => $date,
//             'm_id' => $mId,
//             'gd_id' => $gdId,
//             'start_reading' => $startReading,
//             'end_reading' => $endReading,
//             'finish_good' => $item_list,
//         ]);

//         $readingConsumed = $endReading - $startReading;
//         $totalBatchWeight = 0;

//         foreach ($item_list as $fg) {
//             $fgQuantity = $fg['quantity'];
//             $fgItemId = $fg['r_id'];
//             $fgItem = Item::find($fgItemId);
//             $totalBatchWeight += $fgQuantity * $fgItem->weight;
//         }

//         $unitConsumptionPerKg = round(($readingConsumed / $totalBatchWeight), 3);
//         $stockItems = [];

//         foreach ($item_list as $fg) {
//             $fgWaste = $fg['waste'];
//             $fgQuantity = $fg['quantity'];
//             $fgItemId = $fg['r_id'];
//             $fgItem = Item::find($fgItemId);
//             $fgWeight = $fgItem->weight;
//             $fgWasteQuantity = round($fgWaste / $fgWeight, 3);
//             $fgTotalQuantity = $fgQuantity + $fgWasteQuantity;

//             $fgRm = $fgItem->raw_material;
//             $unit = $unitConsumptionPerKg * $fgItem->weight;

//             $stockItems[] = [
//                 'item_id' => $fgItemId,
//                 'quantity' => $fgQuantity,
//                 'unit' => $unit,
//                 'gd_id' => $gdId,
//                 'vch_type' => 'mfg',
//                 'vch_no' => $manufacture->id,
//                 'm_id' => $mId,
//             ];

//             $rawMaterials = unserialize($fgRm);

//             foreach ($rawMaterials as $rm) {
//                 $rId = $rm['r_id'];
//                 $quantity = floatval($rm['quantity']) * floatval($fgTotalQuantity);

//                 $stockItems[] =  [
//                     'item_id' => $rId,
//                     'quantity' => (0 - $quantity),
//                     'vch_type' => 'mfg',
//                     'vch_no' => $manufacture->id,
//                     'm_id' => $mId,
//                     'gd_id' => $gdId
//                 ];
//             }
//         }

//         Manufacturing::insert($stockItems);
//         $request->session()->forget('manufacture');

//         if ($manufacture) {
//             return redirect()->route('manufacturings.index')->with('success', 'Manufacturing saved successfully!');
//         } else {
//             return redirect()->route('manufacturings.index')->with('error', 'Something went wrong. Please try again.');
//         }
//     }
// }
