<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Models\Login;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Password;
use Stevebauman\Location\Facades\Location;

class AuthController extends Controller
{
    use HttpResponses;

    /**
     * Log the user in.
     *
     * @return JsonResponse
     */
    public function login(Request $request, UserLoginRequest $loginRequest)
    {
        $loginRequest->validated($loginRequest->only(['email', 'password']));

        if (!Auth::attempt($loginRequest->only(['email', 'password']))){
            return $this->error('', 'Credentials do not match.', 401);
        }

        $user = User::where('email', $loginRequest->email)->first();

        // $location = Location::get($request->ip());
        // Login::create([
        //     'user_id'=>$user->id,
        //     'ip'=>$request->ip(),
        //     'country'=>$location->countryName,
        //     'country_code'=>$location->countryCode,
        //     'region'=>$location->regionName,
        //     'region_code'=>$location->regionCode,
        //     'city'=>$location->cityName,
        //     'zip'=>$location->zipCode,
        //     'lat'=>$location->latitude,
        //     'long'=>$location->longitude,
        //     'login_date_time'=>Carbon::now()->format('Y/m/d H:i:m')
        // ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('LoginToken')->plainTextToken
        ]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function register(Request $request, StoreUserRequest $userRequest)
    {
        $userRequest->validated($userRequest->all());

        $user = User::create([
            'fname'=>$userRequest->fname,
            'lname'=>$userRequest->fname,
            'picture'=>$userRequest->picture,
            'email'=>$userRequest->email,
            'phone'=>$userRequest->phone,
            'dob'=>Carbon::parse($userRequest->dob),
            'address'=>$userRequest->address,
            'password'=>Hash::make($userRequest->password)
        ]);
        event(new Registered($user));

        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('RegisterToken')->plainTextToken
        ]);
    }

    /**
     * Log the user out.
     *
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('sanctum')->user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'You have been logged out and your token has been removed'
        ]);
    }

    /**
     * Send the user a verification email.
     *
     * @return RedirectResponse
     */
    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return redirect(route('already'));
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect(route('verify'));
    }

    /**
     * Resend the user a verification email.
     *
     * @return RedirectResponse
     */
    public function resend(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }

    /**
     * Change the user's password.
     *
     * @return JsonResponse
     */
    public function change(ChangePasswordRequest $changePasswordRequest, User $user){
        $changePasswordRequest->validated($changePasswordRequest->all());

        if (!Hash::check($changePasswordRequest->old_password, Auth::user()->password))
        {
            return $this->error('', 'Your old password does not match our records.', 401);
        }

        if (Hash::check($changePasswordRequest->new_password, Auth::user()->password))
        {
            return $this->error('', 'Your new password cannot be your old password.', 401);
        }

        $user->update(['password'=>Hash::make($changePasswordRequest->new_password)]);

        return $this->success([
            'message' => 'Your password has been changed successfully.'
        ]);
    }

    /**
     * Send the user a password reset email.
     *
     * @return JsonResponse
     */
    public function forgot(ForgotPasswordRequest $forgotPasswordRequest)
    {
        $forgotPasswordRequest->validated($forgotPasswordRequest->all());

        $response = Password::sendResetLink($forgotPasswordRequest->only('email'));
        switch ($response) {
            case Password::RESET_LINK_SENT:
                return $this->success('', trans($response), 200);
            case Password::INVALID_USER:
                return $this->error('', trans($response), 400);
        }
    }

    /**
     * Send the user a password reset email.
     *
     * @return JsonResponse
     */
    public function reset(ResetPasswordRequest $resetPasswordRequest){
        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $status = Password::reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($status == Password::INVALID_TOKEN) {
            return $this->error('', "Invalid token", 400);
        }

        return $this->success('', "Password has been successfully changed");
    }
}
