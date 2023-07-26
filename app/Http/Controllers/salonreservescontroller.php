<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Salon_reserves;
use App\Models\Available_times;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class salonreservescontroller extends Controller
{
    public function add_salon_reserve(Request $request)
    {
        $available_time = Available_times::find($request->input('id'));
        $salon_reserve = new Salon_reserves;
        $salon_reserve->salon_id = $available_time->salon_id;
        $salon_reserve->day = $request->input('day');
        $salon_reserve->start_time = $available_time->start_time;
        $salon_reserve->end_time = $available_time->end_time;
        $salon_reserve->price = $available_time->price;
        $salon_reserve->user_id = Auth::id();
        $salon_reserve->save();
        return 'سالن برای شما رزرو شد';
    }
    public function get_salon_reserves_salon_id(Request $request)//reserv haee ke ye salon dashte
    {
        $salon_reserves = DB::table('salon_reserves')->where('salon_id', $request->input('salon_id'))->get();
        return response()->json($salon_reserves);
    }    
    public function get_salon_reserves_user_id(Request $request)//reserv haye shoma
    {
        $salon_reserves = DB::table('salon_reserves')->where('user_id', Auth::id())->get();
        return response()->json($salon_reserves);
    }    
    public function delete_salon_reserve(Request $request)
    {
        $salon_reserve = Salon_reserves::find($request->input('id'));
        if($salon_reserve->user_id != Auth::id())
            return 'شما نمیتوانید این رزرو را کنسل کنید';
        $salon_reserve->delete();
        return 'رزرو حذف شد';
    }
}
