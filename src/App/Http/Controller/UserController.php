<?php

declare(strict_types=1);

namespace Bima\App\Http\Controller;

use Bima\User\Model\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class UserController
{
    public function index(): Response
    {
        return Inertia::render('User/Pages/Index', [
            'users'       => User::latest()->get(),
            'newPassword' => session('generated_password'),
        ]);
    }

    public function show(int $user): Response
    {
        return Inertia::render('User/Pages/Detail', [
            'user'        => User::findOrFail($user),
            'newPassword' => session('generated_password'),
        ]);
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name'  => 'required|string',
            'email' => 'required|email',
        ])->validateWithBag('createUser');

        User::create([
            ...$data,
            'password' => $newPassword = User::newPassword(),
        ]);

        return back()->with('generated_password', $newPassword);
    }

    public function update(int $user, Request $request): RedirectResponse
    {
        $data = Validator::make($request->all(), [
            'name'  => 'required|string',
            'email' => 'required|email',
        ])->validateWithBag('updateUserInformation');

        User::findOrFail($user)->fill($data)->save();

        return back();
    }

    public function generatePassword(int $user): RedirectResponse
    {
        $newPassword = User::newPassword();

        $user = User::findOrFail($user);
        $user->password = $newPassword;
        $user->save();

        return back()->with('generated_password', $newPassword);
    }

    public function delete(int $id)
    {
        if (auth()->user()->id === $id) {
            return back()->with('message.error', 'Cannot delete your own account.');
        }

        User::findOrFail($id)->delete();

        return to_route('user.list')->with('message.success', 'User has been deleted successfully.');
    }
}
