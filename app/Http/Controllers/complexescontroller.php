<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Complexes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class complexescontroller extends Controller
{
    public function add_complex(Request $request)
    {
        $complex = new Complexes;
        $complex->name = $request->input('name');
        $complex->phone = $request->input('phone');
        $complex->email = $request->input('email');
        $complex->creator_id = Auth::id();
        $complex->save();
        return 'ورزشگاه شما ثبت شد';
    }
    public function get_complexes()
    {
        $complex = DB::table('complexes')->where('verify', 1)->get();
        return response()->json($complex);
    }
    public function get_all_complexes()
    {
        $complex = DB::table('complexes')->get();
        return response()->json($complex);
    }
    public function get_my_complexes()
    {
        $user = User::find(Auth::id());
        $complexes = $user->complexes;
        return response()->json($complexes);
    }
    public function update_verify(Request $request)
    {
        if(Auth::id() != 1)
            return 'شما نمیتوانید تغییری در اطلاعات ورزشگاه وارد کنید';
        $Complexe = Complexes::find($request->input('id'));
        $Complexe->verify = $request->input('verify');
        $Complexe->save();
        return 'تغییر انجام شد';
    }
    public function delete_complex(Request $request)
    {
        $complex = Complexes::find($request->input('id'));
        if($complex->creator_id != Auth::id() && Auth::id() != 1)
            return 'شما نمیتوانید این ورزشکاه را حذف کنید';
        DB::table('roles')->where('complex_id', '=', $request->input('id'))->delete();
        $salons = DB::table('salons')->where('complex_id', $request->input('id'))->get();
        for($i=0;$i<count($salons);$i++){
            DB::table('available_times')->where('salon_id', '=', $salons[$i]->id)->delete();
            DB::table('salon_reserves')->where('salon_id', '=', $salons[$i]->id)->delete();
        }
        DB::table('salons')->where('complex_id', $request->input('id'))->delete();
        $complex->delete();
        return 'ورزشگاه حذف شد';
    }
}
