<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\ApiKey;
use Illuminate\Support\Str;

class AuthController extends Controller
{
   
    public function register (RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
    public function login (LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('projects.list')->with('success', 'Login successful!');
        }
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); 

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'image' => 'nullable|image',
            'password' => 'nullable|string|min:8',
        ]);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }else{
            $validated['password'] = bcrypt($validated['password']);
        }
  
    
        $user->update($validated);
    
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    public function index_key(){
      $user = Auth::user();
      $apiKey = $user ? ApiKey::where('user_id', $user->id)->first() : null;
      return view('api_key_generate_page', compact('apiKey'));
    }


    public function generateApiKey(Request $request)
    {
        $request->validate([
            'purpose' => 'required|string|max:255',
        ]);
    
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    
        $apiKey = ApiKey::firstOrCreate(
            ['user_id' => $user->id],
            ['key' => Str::random(32), 'quota' => 100]
        );
    
        return redirect()->route('apikey-page')->with('success', 'API Key generated successfully.')->with('apiKey', $apiKey);
    }
}

