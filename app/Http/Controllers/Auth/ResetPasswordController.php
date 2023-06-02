<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email);
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(
            [
                'success' => true,
                'message' => "Your password has been reset",
            ],
            200
        );
    }
}
