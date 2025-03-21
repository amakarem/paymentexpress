<?php

namespace App\Http\Controllers;

use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function gateways()
    {
        return view('gateways');
    }
    public function paymentlist()
    {
        return view('paymentlist');
    }
    public function generatepaymentkey()
    {
        $newkey['paymentkey'] = base64_encode(Auth::user()->email . time());
        DB::table('users')
            ->where([['id', '=', Auth::user()->id], ['paymentkey', '=', '']])
            ->orWhere([['id', '=', Auth::user()->id], ['paymentkey', '=', '0']])
            ->orWhere([['id', '=', Auth::user()->id], ['paymentkey', '=', NULL]])
            ->update($newkey);
        return redirect('home');
    }
    public function gatewaysetup()
    {
        if (isset($_POST['gateway'])) {
            $table = $_POST['gateway'];
            unset($_POST['_token']);
            unset($_POST['gateway']);
            if (isset($_POST['sandbox'])) {
                $_POST['sandbox'] = 1;
            } else {
                $_POST['sandbox'] = 0;
            }
            if (isset($_POST['disabled'])) {
                $_POST['disabled'] = 1;
            } else {
                $_POST['disabled'] = 0;
            }
            $_POST['owner'] = Auth::user()->id;
            $key['owner'] = Auth::user()->id;
            DB::table($table)->updateOrInsert($key, $_POST);
        }
        return redirect('gateways');
    }
}
