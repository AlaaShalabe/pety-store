<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\forgetPasswordRequest;
use App\Mail\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function forgetPassword(forgetPasswordRequest $request)
    {

        $email = $request->only('email');
        $user = User::where('email', $email)->first();
        if ($user) {
            $verify2 =  DB::table('password_resets')->where([
                ['email', $request->all()['email']]
            ]);

            if ($verify2->exists()) {
                $verify2->delete();
            }
        }
        $token = random_int(1000, 9999);
        $passwordReset = DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        if ($passwordReset) {

            Mail::to($request->email)->send(new ResetPassword($token));
            return response()->json(
                [
                    'success' => true,
                    'message' => "Please check your email for a 4 digit pin"
                ],
                200
            );
        } else {
            return response()->json([
                'success' => false,
                'message' => "This email does not exist"
            ],  400);
        }
    }

    public function verifycode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $check = DB::table('password_resets')->where([
            ['token', $request->all()['token']],
        ]);

        if ($check->exists()) {
            $difference = Carbon::now()->diffInSeconds($check->first()->created_at);
            if ($difference > 3600) {
                return response()->json(['success' => false, 'message' => "Token Expired"], 400);
            }

            DB::table('password_resets')->where([
                ['token', $request->all()['token']],
            ])->delete();

            return response()->json(
                [
                    'success' => true,
                    'message' => "You can now reset your password"
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => "Invalid token"
                ],
                401
            );
        }
    }
}
