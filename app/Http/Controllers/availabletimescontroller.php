<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Available_times;
use App\Models\Salons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class availabletimescontroller extends Controller
{
    public function add_available_time(Request $request)
    {
        $salon = Salons::find($request->input('salon_id'));
        if($salon->creator_id != Auth::id())
            return 'شما نمیتوانید برای این سالن زمان اضافه کنید';
        $check = DB::table('available_times')->whereRaw('(start_time = ? or end_time = ?) and week_day = ?', [$request->input('start_time'), $request->input('end_time'), $request->input('week_day')])->get();
        if(isset($check[0]))
            return 'زمان شما با دیگر زمان‌ها تداخل دارد';
        $check = DB::table('available_times')->whereRaw('(start_time < ? and end_time > ?) and week_day = ?', [$request->input('start_time'), $request->input('start_time'), $request->input('week_day')])->get();
        if(isset($check[0]))
            return 'زمان شما با دیگر زمان‌ها تداخل دارد';
        $check = DB::table('available_times')->whereRaw('(start_time < ? and end_time > ?) and week_day = ?', [$request->input('end_time'), $request->input('end_time'), $request->input('week_day')])->get();
        if(isset($check[0]))
            return 'زمان شما با دیگر زمان‌ها تداخل دارد';
        $Available_time = new Available_times;
        $Available_time->salon_id  = $request->input('salon_id');
        $Available_time->start_time = $request->input('start_time');
        $Available_time->end_time = $request->input('end_time');
        $Available_time->price = $request->input('price');
        $Available_time->week_day = $request->input('week_day');
        $Available_time->save();
        return 'زمان ثبت شد';
    }
    public function get_available_times(Request $request)
    {
        $Available_times = DB::table('available_times')->where('salon_id', $request->input('salon_id'))->orderByRaw('week_day, start_time')->get();
        return response()->json($Available_times);
    }
    public function get_available_times_day_of_week(Request $request)
    {
        $available_times = DB::select("
        SELECT available_times.*
        FROM available_times
        LEFT JOIN salon_reserves
        ON available_times.start_time = salon_reserves.start_time AND salon_reserves.day = ?
        WHERE salon_reserves.salon_id IS NULL AND available_times.salon_id = ? AND available_times.week_day = ?
    ", [$request->input('day'), $request->input('salon_id'), $request->input('week_day')]);
//        $Available_times = DB::table('available_times')->whereRaw('salon_id = ? and week_day = ?', [$request->input('salon_id'), $request->input('week_day')])->orderBy('start_time')->get();
        return response()->json($available_times);
    }
    public function delete_available_time(Request $request)
    {
        $available_time = Available_times::find($request->input('id'));
        $salon = Salons::find($available_time->salon_id);
        if($salon->creator_id != Auth::id())
            return 'شما نمیتوانید این زمان را حذف کنید';
        $available_time->delete();
        return 'زمان حذف شد';
    }
}
