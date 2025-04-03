<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Setting;
use App\Models\User;

class UserAuthController extends Controller
{


    public function userLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|string',
                'password' => 'required|string',
                'remember_token' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->messages()->all()
                ]);
            }

            $credentials = $request->only('email', 'password');

            // Check if the user is already logged in
            $adminToken = $request->cookie('auth_user_data');
            if ($adminToken) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You are already logged in as a user. Please log out first.',
                ]);
            }

            $admin = User::where('email', $credentials['email'])
                ->where('active', 1)  // Ensure the user is active
                ->first();

            if ($admin && Hash::check($credentials['password'], $admin->password)) {

                $rememberMe = $request->input('remember_token');
                $remember = $rememberMe ? Str::random(60) : null;
                $admin->remember_token = $remember;
                $admin->save();

                $token = $admin->createToken('AdminToken', ['admin'])->accessToken;

                $adminInfo = [
                    'name' => $admin->firstname,
                    'email' => $admin->email,
                    'avatar' => $admin->avatar,
                    'phone' => $admin->phone,
                ];

                $websiteInfo = Setting::all();

                return response()->json([
                    'status' => 200,
                    'token' => $token,
                    'remember_me' => $rememberMe,
                    'user_info' => $adminInfo,
                    'settings' => $websiteInfo
                ]);
            } else {
                return response()->json(['status' => 401, 'message' => 'Wrong login details entered'],);
            }
        } catch (Exception $e) {
            // Log the actual error message for debugging purposes
            Log::error($e->getMessage());
            return response()->json(['status' => 500, 'message' => 'System error occured']);
        }
    }

    public function userLogout()
    {
        try {
            if (Auth::check()) {
                Auth::user()->token()->revoke();
                return response()->json(['status' => 204, 'message' => 'Logout was successful']);
            }
            return response()->json(['status' => 401, 'message' => 'You are not unauthorized for this action']);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => 500, 'message' => 'System error occured']);
        }
    }
}
