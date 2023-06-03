<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function changeImage(Request $request, $id)
    {
        $data = $request->only(['image', 'password']);
        $request->validate([
            'password' => 'required',
            'image' => 'required|file|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ], $data);

        $user = User::findOrFail($id);
        $password = $user->password;
        if ($request->hasFile('iamge')) {
            $user->update([
                'image' => $request->file('iamge')->store('public/post_images'),
            ]);
            if ($request['password'] = $password) {

                return response()->json([
                    'messamge' => 'update your address',
                    'user' => $user
                ]);
            }
            return response()->json([
                'messamge' => 'erorr in your password',
                'msg' => 0
            ]);
            return response()->json([
                'messamge' => 'update your iamge',
                'user' => $user
            ]);
        }
        return response()->json([
            'messamge' => 'erorr',
            'user' => $user
        ]);
    }

    public function changeAddress(Request $request, $id)
    {
        $data = $request->only('address', 'password');

        $request->validate([
            'address' => 'required|string',
            'password' => 'required|string'
        ], $data);

        $user = User::findOrFail($id);
        $password = $user->password;
        if ($request->has('address')) {
            $user->update([
                'address' => $request->address,
            ]);
            if ($request['password'] = $password) {

                return response()->json([
                    'messamge' => 'update your address',
                    'user' => $user
                ]);
            }
            return response()->json([
                'messamge' => 'erorr in your password',
                'msg' => 0
            ]);
        }
    }
}
