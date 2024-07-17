<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DateController extends Controller
{
    public function change_date(Request $request)
    {
        $from_date = $request->from_date;
        $to_date=$request->to_date;
       
        if($request->date_type==2)
        {
            session()->put('from_date',$from_date);
            session()->put('to_date',$to_date);
        }else{
           session()->put('date',$to_date);
        }
        return response()->json(['message' => 'Date range updated successfully']);

    }
    public function index()
    {
        return session()->all();
    }
}
