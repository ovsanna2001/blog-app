<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordLinkRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ResetPasswordLinkRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $status = Password::sendResetLink($request->only('email'));
        $plainToken = Str::random(60);
        $email = $request['email'];
        $user = User::where('email',$email)->first();
        if($user) {
            // Delete exesting email token
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            // Generate a plain token
            $plainToken = Str::random(60);
    
            // Hash the token
            $hashedToken = bcrypt($plainToken);
    
            // Insert new token
            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $hashedToken,
                'created_at' => now(),
            ]);
    
            return response()->json(['reset_token' => $plainToken], 200);
        } else {
            return response()->json(['message' => "This email is not exist"], 200);
        }
    }
}
