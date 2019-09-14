<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            if(isset($_POST['getway'])) {
                $table = $_POST['getway'];
                unset($_POST['_token']);
                unset($_POST['getway']);
                $_POST['owner'] = Auth::user()->id;
                DB::table($table)->updateOrInsert($_POST);
            }
        return redirect('getways');
    }
}
