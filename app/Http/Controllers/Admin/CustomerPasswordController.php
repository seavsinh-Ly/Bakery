<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerPasswordController extends Controller
{
    public function index(): View
    {
        return view('admin.customers.password', [
            'customers' => User::where('role', 'customer')->latest()->get(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'customer', 404);

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('admin.customers.password.edit')
            ->with('success', "Temporary password set for {$user->email}. Share it with the customer securely.");
    }
}
