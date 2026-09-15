<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm(Request $request)
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'document_type' => ['required', 'in:CC,CE,PASAPORTE,NIT'],
            'document_number' => ['required', 'string', 'max:20'],
            'phone_whatsapp' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'document_type' => $validated['document_type'],
            'document_number' => $validated['document_number'],
            'phone_whatsapp' => $validated['phone_whatsapp'],
            'city' => $validated['city'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'is_active' => true,
        ]);

        Auth::login($user);

        // If registering from a course page, redirect to that course
        if ($request->filled('course')) {
            return redirect()->route('courses.show', $request->input('course'));
        }

        return redirect('/cursos');
    }
}
