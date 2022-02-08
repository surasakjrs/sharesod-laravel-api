<?php

namespace App\Http\Controllers\Sharesod;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class PinController extends ApiController
{
    public function getPins(Request $request)
    {
        $pins = DB::table('pins')->select('*')->get();
        return $this->api_respond($pins);
    }

}
