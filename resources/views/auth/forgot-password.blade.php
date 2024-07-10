<!-- Form untuk permintaan reset password -->
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <span role="alert">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <button type="submit">Send Password Reset Link</button>
    </div>
</form>
