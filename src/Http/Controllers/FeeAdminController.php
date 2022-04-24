<?php

namespace Raosys\Fees\Http\Controllers;

use App\Http\Controllers\Controller;

class FeeAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('fees::dashboard', compact('user'));
    }
}
