<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoucherGstController extends Controller
{
    public function index($type='',$action='addddd',$id=0,$mode='gst')
    {
        if($type=='')
        {
            return view('voucher.index');
        }else{
            return view('voucher.vch',['type'=>$type,'action'=>$action,'id'=>$id,'mode'=>$mode]);
        }
    }

}
