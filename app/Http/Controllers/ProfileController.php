<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit(): \Illuminate\View\View
    {
        return view('profile.edit', [
            'user' => Auth::user(),
            'privacyContent' => config('static_content.privacy_content')
        ]);
    }

    /**
     * Update the profile
     *
     * @param ProfileRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileRequest $request): RedirectResponse
    {
        $optIns = ['retain_data', 'post', 'sms', 'email'];
        $optInRequest = [];

        foreach ($optIns as $optin) {
            if ($request->post('can_' . $optin) == '1') {
                $optInRequest['can_' . $optin] = 1;
                $optInRequest[$optin . '_opt_in'] = Carbon::now();
            } else {
                $optInRequest['can_' . $optin] = 0;
                $optInRequest[$optin . '_opt_out'] = Carbon::now();
            }
        }
        auth()->user()->update(
            $request
                ->merge(
                    ['password' =>
                         !empty($request->get('password'))
                             ? Hash::make($request->get('password'))
                             : ''
                    ]
                )
                ->merge($optInRequest)
                ->except(
                // If the password is not set, ignore it
                    [$request->get('password') ? '' : 'password']
                )
        );
        return back()->withStatus(__('Profile successfully updated.'));
    }

    public function subscribe(): Factory|View|Application
    {
        return view('profile.subscribe', ['thing' => Auth::User()]);
    }

    /**
     * Change the password
     *
     * @param PasswordRequest $request
     * @return RedirectResponse
     */
    public function password(PasswordRequest $request): RedirectResponse
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withStatusPassword(__('Password successfully updated.'));
    }
}
