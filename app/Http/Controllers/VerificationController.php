<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class VerificationController extends Controller
{
    public function verify($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->email_verified_at = now();
            $user->save();
            return redirect()->route('login')->with('success', 'Email verified successfully.');
        }

        return redirect()->route('login')->with('error', 'Invalid verification link.');
    }
}
