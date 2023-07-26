<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Salons;
use App\Models\Complexes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class salonscontroller extends Controller
{
    public function add_salon(Request $request)
    {
        $complex = Complexes::find($request->input('complex_id'));
        $role = DB::table('roles')->whereRaw('complex_id = ? and user_id = ?', [$request->input('complex_id'), Auth::id()])->get();
        if(!isset($role[0]) && $complex->creator_id != Auth::id())
            return 'شما نمیتوانید برای این ورزشگاه سالن اضافه کنید زیرا شما در این ورزشگاه ادمین نیستید';
        $salon = new Salons;
        $salon->name = $request->input('name');
        $salon->phone = $request->input('phone');
        $salon->creator_id = Auth::id();
        $salon->complex_id = $request->input('complex_id');
        $salon->save();
        return 'سالن شما ثبت شد';
    }
    public function get_salons(Request $request)
    {
        $salons = DB::table('salons')->where('complex_id', $request->input('complex_id'))->get();
        return response()->json($salons);
    }    
    public function get_my_salons()
    {
        $salons = DB::table('salons')->where('creator_id', Auth::id())->get();
        return response()->json($salons);
    }
    public function delete_salon(Request $request)
    {
        $complex = Complexes::find($request->input('complex_id'));
        $salon = Salons::find($request->input('id'));
        if($salon->creator_id != Auth::id() && $complex->creator_id != Auth::id())
            return 'شما نمیتوانید این سالن را حذف کنید زیرا شما سازنده این سالن نیستید';
        $cid = $salon->complex_id;
        DB::table('available_times')->where('salon_id', '=', $request->input('id'))->delete();
        DB::table('salon_reserves')->where('salon_id', '=', $request->input('id'))->delete();
        $salon->delete();
        return 'سالن حذف شد';
    }
}
