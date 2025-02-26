<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class AdminAuthController extends Controller
{
    public function adminLogin(Request $request)
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

            // Check if the admin is already logged in
            $adminToken = $request->cookie('auth_admin_data');
            if ($adminToken) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You are already logged in as an admin. Please log out first.',
                ]);
            }

            $admin = Admin::where('email', $credentials['email'])
                ->where('active', 1)  // Ensure the admin is active
                ->first();

            if ($admin && Hash::check($credentials['password'], $admin->password)) {

                $rememberMe = $request->input('remember_token');
                $remember = $rememberMe ? Str::random(60) : null;
                $admin->remember_token = $remember;
                $admin->save();

                $token = $admin->createToken('AdminToken', ['admin'])->accessToken;

                $adminInfo = [
                    'firstname' => $admin->firstname,
                    'surname' => $admin->surname,
                    'email' => $admin->email,
                    'photo' => $admin->photo,
                    'phone' => $admin->phone,
                    'admin_type' => $admin->admin_type_id,
                ];

                $websiteInfo = Setting::all();

                return response()->json([
                    'status' => 200,
                    'token' => $token,
                    'remember_me' => $rememberMe,
                    'admin_info' => $adminInfo,
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

    public function adminLogout()
    {
        try {
            if (Auth::guard('admin')->check()) {
                Auth::guard('admin')->user()->token()->revoke();
                return response()->json(['status' => 204, 'message' => 'Logout was successful']);
            }
            return response()->json(['status' => 401, 'message' => 'You are not unauthorized for this action']);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => 500, 'message' => 'System error occured']);
        }
    }
}
