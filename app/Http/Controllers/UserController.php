<?php

namespace App\Http\Controllers;

use App\Entrant;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use \Illuminate\View\View;

class UserController extends Controller {
    protected $templateDir = 'users';
    protected $baseClass = 'App\User';

    /**
     * Display a listing of the users
     *
     * @param \App\User $model
     * @return \Illuminate\View\View
     */
    public function index(User $model): View {
        return view('users.index', ['users' => $model::orderBy('lastname')->where('is_anonymised', false)->orderBy('firstname')->get()]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create(array $extraData = []): View {
        return view('users.create',['privacyContent'=>config('static_content.privacy_content')]);
    }

    /**
     * Store a newly created user in storage
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param \App\User $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model) {
        if (empty($request->get('password'))) {
            $newPassword = '';
        } else {
            $newPassword = Hash::make($request->get('password'));
        }
        $user = $model->create($request->merge(
            [
                'password_reset_token' => '',
                'password' => $newPassword,
                'auth_token' => md5(random_int(PHP_INT_MIN, PHP_INT_MAX))])->all());
        $user->makeDefaultEntrant();

        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param \App\User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user) {
        return view('users.edit', array_merge(compact('user'), ['privacyContent' => config('static_content.privacy_content')]));
    }

    /**
     * Update the specified user in storage
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user) {
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
                ));

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }
    /**
     * Remove the specified user from storage
     *
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user) {
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }
}
