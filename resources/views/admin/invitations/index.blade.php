<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Invitations | Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg, #fffaf3 0%, #f8f1e7 100%); font-family: Arial, sans-serif; }
        .page { padding: 70px 0; }
        .badge-title { background: #f9d9a8; color: #8a5a25; border-radius: 999px; padding: 8px 14px; font-size: .8rem; letter-spacing: .05rem; text-transform: uppercase; }
        .panel { border: 0; border-radius: 18px; background: #fff; box-shadow: 0 8px 24px rgba(116,80,38,.08); }
        .form-control { border-radius: 12px; border: 1px solid #e7d9c5; padding: 12px 14px; background: #fffdfb; }
        .form-control:focus { border-color: #d9a96a; box-shadow: 0 0 0 .2rem rgba(217,169,106,.15); }
        label { font-weight: 600; color: #5e3d26; margin-bottom: 8px; }
        .submit-btn { background: #a86a2f; border: 0; color: #fff; border-radius: 999px; padding: 12px 28px; font-weight: 600; }
        .submit-btn:hover { background: #8b4f24; color: #fff; }
        .table thead th { color: #8a6a4d; font-size: .75rem; text-transform: uppercase; letter-spacing: .06em; }
    </style>
</head>
<body class="bg-light">
    <div class="container page">
        <div class="text-center mb-4">
            <span class="badge-title">Team access</span>
            <h1 class="display-6 fw-bold text-dark mt-3">Admin Invitations</h1>
            <p class="text-muted">Invite trusted team members to manage the bakery.</p>
        </div>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Back to Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('invitation_url'))
            <div class="alert alert-info">
                <h2 class="h6">Invitation link</h2>
                <p class="mb-2">Share this link with the invited user:</p>
                <div class="input-group">
                    <input
                        id="invitation-url"
                        type="text"
                        class="form-control"
                        value="{{ session('invitation_url') }}"
                        readonly
                    >
                    <button
                        type="button"
                        class="btn btn-outline-primary"
                        onclick="copyInvitationLink()"
                    >
                        Copy link
                    </button>
                </div>
                <a
                    class="d-inline-block mt-2"
                    href="{{ session('invitation_url') }}"
                    target="_blank"
                    rel="noopener"
                >
                    Open invitation link
                </a>
                <span id="copy-status" class="ms-2 text-success" aria-live="polite"></span>
            </div>
        @endif

        <div class="panel p-4 mb-4">
                <form method="POST" action="{{ route('admin.invitations.store') }}">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label">Invite admin by email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn submit-btn w-100">Send Invite</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="panel p-4">
                <div class="table-responsive"><table class="table align-middle mb-0">
                    <thead>
                        <tr><th>Email</th><th>Status</th><th>Invited By</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @foreach($invitations as $invitation)
                            <tr>
                                <td>{{ $invitation->email }}</td>
                                <td>{{ ucfirst($invitation->status) }}</td>
                                <td>{{ $invitation->inviter?->name ?? 'System' }}</td>
                                <td>
                                    @if($invitation->status === 'accepted')
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('admin.invitations.approve', $invitation) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                            </form>
                                            <form action="{{ route('admin.invitations.reject', $invitation) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table></div>
        </div>
    </div>

    <script>
        function copyInvitationLink() {
            const input = document.getElementById('invitation-url');
            const status = document.getElementById('copy-status');

            navigator.clipboard.writeText(input.value).then(function () {
                status.textContent = 'Copied.';
            }).catch(function () {
                input.select();
                document.execCommand('copy');
                status.textContent = 'Copied.';
            });
        }
    </script>
</body>
</html>
