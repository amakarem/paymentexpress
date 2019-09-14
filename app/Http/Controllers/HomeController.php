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
    public function getways()
    {
        return view('getways');
    }
    public function getwaysetup()
    {
        if (isset($_POST['getway'])) {
            $table = $_POST['getway'];
            unset($_POST['_token']);
            unset($_POST['getway']);
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
            DB::table($table)->updateOrInsert($key,$_POST);
        }
        return redirect('getways');
    }
}
