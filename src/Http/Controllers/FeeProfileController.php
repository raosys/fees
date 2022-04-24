<?php

namespace Raosys\Fees\Http\Controllers;

use App\Http\Controllers\Controller;


class FeeProfileController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('fees::profile', compact('user'));
    }
}
