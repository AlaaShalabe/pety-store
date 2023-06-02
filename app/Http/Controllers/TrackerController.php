<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use Stevebauman\Location\Facades\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackerController extends Controller
{
    public function index(Request $request)
    {
        $tracker = Tracker::where("code", "=", $request->code)->first();
        if ($tracker->user_id == Auth::user()->id) {
            
            // $ip = $request->ip(); /* Dynamic IP address */
            $ip = '193.124.163.220'; /* Static IP address */
            $GPS = Location::get($ip);
            return response()->json(['GPS' => $GPS]);
        }
        return response()->json([
            'message' => 'Tracker not exist or you are not allow to check this tracker',
        ]);
    }
}
