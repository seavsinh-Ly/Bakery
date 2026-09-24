<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CustomerPasswordController extends Controller
{
    public function index(): View
    {
        return view('admin.customers.password', [
            'customers' => User::query()
                ->where('role', 'customer')
                ->where('status', 'approved')
                ->orderBy('email')
                ->get(['id', 'name', 'email']),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => [
                'required',
                Rule::exists('users', 'id')->where(fn ($query) => $query
                    ->where('role', 'customer')
                    ->where('status', 'approved')),
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $customer = User::query()->findOrFail($validated['customer_id']);
        $customer->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('admin.customers.password.edit')
            ->with('success', "Password reset successfully for {$customer->email}.");
    }
}
