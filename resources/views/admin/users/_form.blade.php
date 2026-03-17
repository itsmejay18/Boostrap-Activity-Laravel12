@csrf

<div class="card-body">
    <div class="form-group">
        <label for="name">Name</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $user->name) }}"
            class="form-control @error('name') is-invalid @enderror"
            placeholder="Enter full name"
            required
        >
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email', $user->email) }}"
            class="form-control @error('email') is-invalid @enderror"
            placeholder="Enter email address"
            required
        >
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">
            Password
            @if ($user->exists)
                <small class="text-muted">(leave blank to keep current password)</small>
            @endif
        </label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="{{ $user->exists ? 'Update password' : 'Create a password' }}"
            {{ $user->exists ? '' : 'required' }}
        >
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            class="form-control"
            placeholder="Confirm password"
            {{ $user->exists ? '' : 'required' }}
        >
    </div>
</div>

<div class="card-footer d-flex justify-content-between">
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>
