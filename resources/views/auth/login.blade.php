<x-guest-layout>
    <div class="auth-header" style="text-align:center; margin-bottom:30px;">
        <a href="/" class="auth-logo" style="display:inline-block; width:72px; height:72px; border-radius:20px; overflow:hidden; box-shadow:0 12px 32px rgba(99,102,241,0.2); border:0.5px solid rgba(255,255,255,0.1); margin-bottom:20px;">
            <img src="{{ asset('images/logo-rafauzi.jpeg') }}" alt="Logo Rafauzi" style="width:100%; height:100%; object-fit:cover;">
        </a>
        <h1 class="auth-title" style="font-family:'Sora',sans-serif; font-size:24px; font-weight:700; color:#fff; margin-bottom:8px; letter-spacing:-0.5px;">Selamat Datang</h1>
        <p class="auth-subtitle" style="font-size:14px; color:#6e70a0;">Masuk kembali ke akun Toko Parabot Rafauzi Anda.</p>
    </div>

    <div class="auth-body">
        @if (session('status'))
            <div style="color:#4ade80; font-size:13px; margin-bottom:16px;">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:16px;">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" style="display:block; font-size:13px; font-weight:500; color:#a5b4fc; margin-bottom:8px;">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="contoh@email.com"
                       style="width: 100%; background: rgba(255,255,255,0.03); border: 0.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 14px 16px; color: #fff; font-size: 14px; outline: none; transition: 0.2s;"
                       onfocus="this.style.borderColor='#6366f1'; this.style.background='rgba(99,102,241,0.05)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.background='rgba(255,255,255,0.03)'">
                @error('email') <div class="input-error" style="color:#ef4444; font-size:12px; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" style="display:block; font-size:13px; font-weight:500; color:#a5b4fc; margin-bottom:8px;">Kata Sandi</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                       style="width: 100%; background: rgba(255,255,255,0.03); border: 0.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 14px 16px; color: #fff; font-size: 14px; outline: none; transition: 0.2s;"
                       onfocus="this.style.borderColor='#6366f1'; this.style.background='rgba(99,102,241,0.05)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.background='rgba(255,255,255,0.03)'">
                @error('password') <div class="input-error" style="color:#ef4444; font-size:12px; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <!-- Remember Me -->
            <div style="display:flex; align-items:center; gap:8px;">
                <input id="remember_me" type="checkbox" name="remember" style="width:auto; cursor:pointer; accent-color:#6366f1;">
                <label for="remember_me" style="margin:0; font-size:13px; cursor:pointer; color:#a5b4fc;">Ingat Saya</label>
            </div>

            <button type="submit" style="width: 100%; padding: 14px; border-radius: 12px; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; font-size: 15px; font-weight: 600; border: none; cursor: pointer; transition: 0.2s; margin-top: 8px;"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.opacity='0.9'"
                    onmouseout="this.style.transform='none'; this.style.opacity='1'">
                Log in Sekarang
            </button>

            <!-- AUTH FOOTER DIV YANG SUDAH DINAIKKAN -->
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:13px; margin-top:0px;">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color:#a5b4fc; text-decoration:none; transition:0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#a5b4fc'">Lupa Password?</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" style="color:#a5b4fc; text-decoration:none; transition:0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#a5b4fc'">Belum Punya Akun?</a>
                @endif
            </div>
        </form>
    </div>
</x-guest-layout>
