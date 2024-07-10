<!-- Form untuk reset password -->
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
        @error('email')
            <span role="alert">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required autocomplete="new-password">
        @error('password')
            <span role="alert">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
    </div>
    <div>
        <button type="submit">Reset Password</button>
    </div>
</form>
