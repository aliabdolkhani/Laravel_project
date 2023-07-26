<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Roles;
use App\Models\Complexes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class rolescontroller extends Controller
{
    public function add_role(Request $request)
    {
        $Role = new Roles;
        $Role->complex_id = $request->input('complex_id');
        $complex = Complexes::find($request->input('complex_id'));
        if($complex->creator_id != Auth::id())
            return 'شما نمیتوانید برای این ورزشکاه ادمین اضافه کنید';
        $r = DB::table('roles')->whereRaw('complex_id = ? and user_id = ?', [$request->input('complex_id'),$request->input('user_id')])->get();
        if(isset($r[0]))
            return 'این ادمین قبلا ثبت شده است';
        $u = DB::table('users')->where('id', $request->input('user_id'))->get();
        if(!isset($u[0]))
            return 'این شخص در سایت ثبت نام نکرده است';
        $Role->role = "admin";
        $Role->user_id = $request->input('user_id');
        $Role->save();
        return 'نقش ثبت شد';
    }
    public function get_roles(Request $request)
    {
        $Role = DB::table('users')//query be shekl laravel
        ->join('roles', 'users.id', '=', 'roles.user_id')
        ->select('users.*', 'roles.id as rid')
        ->where('roles.complex_id', $request->input('complex_id'))
        ->get();
//        $salons = DB::table('roles')->where('complex_id', $request->input('complex_id'))->get();
        return response()->json($Role);
    }
    public function delete_role(Request $request)
    {
        $Role = Roles::find($request->input('id'));
        $complex = DB::table('complexes')->where('id', $Role->complex_id)->get();

        $complex = Complexes::find($Role->complex_id);
        if($complex->creator_id != Auth::id())
            return 'شما نمیتوانید ادمین این ورزشگاه را حذف کنید';
        
        $Role->delete();
        return 'نقش حذف شد';
    }
}
