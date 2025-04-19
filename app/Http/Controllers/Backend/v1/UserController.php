<?php

namespace App\Http\Controllers\Backend\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function storeUser(Request $request, $id = null)
    {
        if ($id) {
            $user = User::find($id);
            if (!$user) {
                return redirect()->back()->withErrors(['error' => 'Cannot found User']);
            }
        }

        $requirements = [
            'profile' => ['nullable', 'file', 'mimes:jpg,jpeg,png,svg'],
            'username' => ['required', $id ? 'unique:users,username,' . $id : 'unique:users,username',],
            'phone_number' => ['required', $id ? 'unique:users,phone_number,' . $id : 'unique:users,phone_number'],
        ];

        if (!$id) {
            $requirements['name'] = ['required'];
            $requirements['role'] = ['required', 'in:worker,tasker,admin'];
            $requirements['password'] = ['required'];
        }

        $validator = Validator::make($request->all(), $requirements);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'username', 'phone_number']);
        if ($request->hasFile('profile')) {
            $profile = $request->file('profile')->store('profiles/users/' . $request->username, 'public');
            $data['profile'] = $profile;
        } else {
            $data['profile'] = $id ? ($user->profile ?? 'profiles/default.png') : 'profiles/default.png';
        }

        if ($id && $request->phone_number != $user->phone_number) {
            $data['phone_number_verified_at'] = null;
        }

        if (!$id) {
            $data['role'] = $request->role;
            $data['password'] = bcrypt($request->password);
        }

        $user = User::updateOrCreate(
            ['id' => $id],
            $data
        );

        $message = $id == null ? 'User created Successfully' : 'User updated Successfully';
        return redirect()->back()->with(['message' => $message]);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'Cannot found User']);
        }

        $user->delete();

        return redirect()->back()->with(['message' => 'User deleted Successfully']);
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'Cannot found User']);
        }

        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!password_verify($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['error' => 'Old password is incorrect']);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->back()->with(['message' => 'Password changed Successfully']);
    }

    public function sendCode(Request $request)
    {
        $user = $request->user();

        // Schema::create('users', function (Blueprint $table) {
        //     $table->uuid('id')->primary();
        //     $table->string('name');
        //     $table->string('username')->unique();
        //     $table->enum('role', ['worker', 'tasker', 'admin'])->default('worker');
        //     $table->string('phone_number')->unique();
        //     $table->timestamp('phone_verified_at')->nullable();
        //     $table->string('phone_verification_code')->nullable();
        //     $table->timestamp('phone_verification_code_expiry')->nullable();
        //     $table->string('profile')->nullable();
        //     $table->string('password');
        //     $table->rememberToken();
        //     $table->timestamps();
        // });
        if ($user->phone_verified_at) {
            return redirect()->back()->withErrors(['error' => 'Phone number already verified']);
        }

        $code = random_int(100000, 999999);
        $user->phone_verification_code = $code;
        $user->phone_verification_code_expiry = now()->addMinutes(10);
        $user->save();

        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $user->phone_number,
            'message' => "Your verification code is: {$code}",
            'countryCode' => '62',
        ]);

        if ($response->successful()) {
            return redirect()->back()->with(['message' => "Verification code is sent to the number {$user->phone_number}"]);
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to send verification code']);
        }
}

    // DATA
    public function users(Request $request, $id = null)
    {
        $search = $request->input('search');
        if ($id) {
            $user = User::select('id', 'username')->where('id', $id)->first();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return $user;
        }
        $users = User::where('role', 'worker')->select('id', 'username')->when(
            $search,
            function ($query, $search) {
                return $query->where('username', 'like', "%{$search}%");
            },
            function ($query) {
                return $query->latest()->take(4);
            }
        )->get();

        return $users;
    }
}
