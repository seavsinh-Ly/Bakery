<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminInvitationMail;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function index(): View
    {
        return view('admin.invitations.index', [
            'invitations' => Invitation::with('inviter')->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:invitations,email'],
        ]);

        $invitation = Invitation::create([
            'email' => $validated['email'],
            'token' => Str::random(32),
            'invited_by' => $request->user()->id,
            'status' => 'sent',
            'expires_at' => now()->addDays(7),
        ]);

        try {
            Mail::to($invitation->email)->send(new AdminInvitationMail($invitation));
            $message = 'Admin invitation sent.';
        } catch (\Throwable $e) {
            $message = 'Invitation saved, but email delivery failed. Please update SMTP settings.';
        }

        return redirect()
            ->route('admin.invitations.index')
            ->with('success', $message)
            ->with('invitation_url', route('invite.accept', $invitation->token));
    }

    public function accept(string $token)
    {
        $invitation = Invitation::where('token', $token)->where('status', 'sent')->firstOrFail();

        return view('admin.invitations.accept', [
            'invitation' => $invitation,
        ]);
    }

    public function registerInvitedAdmin(Request $request, string $token): RedirectResponse
    {
        $invitation = Invitation::where('token', $token)->where('status', 'sent')->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::firstOrCreate([
            'email' => $invitation->email,
        ], [
            'name' => $validated['name'],
            'password' => bcrypt($validated['password']),
            'role' => 'customer',
            'status' => 'pending',
        ]);

        $user->update([
            'name' => $validated['name'],
            'password' => bcrypt($validated['password']),
            'role' => 'customer',
            'status' => 'pending',
        ]);

        $invitation->update([
            'status' => 'accepted',
        ]);

        return redirect()->route('login')->with('success', 'Your admin request has been submitted and is waiting for approval.');
    }

    public function approve(Invitation $invitation): RedirectResponse
    {
        $user = User::where('email', $invitation->email)->first();

        if ($user) {
            $user->update([
                'role' => 'admin',
                'status' => 'approved',
            ]);
        }

        $invitation->update([
            'status' => 'approved',
        ]);

        return redirect()->route('admin.invitations.index')->with('success', 'Admin invitation approved.');
    }

    public function reject(Invitation $invitation): RedirectResponse
    {
        $user = User::where('email', $invitation->email)->first();

        if ($user) {
            $user->update([
                'status' => 'rejected',
            ]);
        }

        $invitation->update([
            'status' => 'rejected',
        ]);

        return redirect()->route('admin.invitations.index')->with('success', 'Admin invitation rejected.');
    }
}
