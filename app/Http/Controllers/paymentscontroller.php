<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class paymentscontroller extends Controller
{
    public function add_payment(Request $request)
    {
        $Payments = new Payments;
        $Payments->user_id = Auth::id();
        $Payments->payment_date = $request->input('payment_date');
        $Payments->status = $request->input('status');
        $Payments->amount = $request->input('amount');
        $Payments->payment_id = $request->input('payment_id');
        $Payments->salon_id = $request->input('salon_id ');
        $Payments->save();
        return 'هزینه ثبت شد';
    }
    public function get_payments(Request $request)
    {
        $Payments = DB::table('payments')->where('user_id ', $request->input('user_id '))->get();
        return response()->json($Payments);
    }
    public function delete_payment(Request $request)
    {
        $Payment = Payments::find($request->input('id'));
        $Payment->delete();
        return 'هزینه حذف شد';
    }
}
