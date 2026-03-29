<x-guest-layout>
    <div class="auth-header" style="text-align:center; margin-bottom:30px;">
        <a href="/" class="auth-logo" style="display:inline-block; width:72px; height:72px; border-radius:20px; overflow:hidden; box-shadow:0 12px 32px rgba(99,102,241,0.2); border:0.5px solid rgba(255,255,255,0.1); margin-bottom:20px;">
            <img src="{{ asset('images/logo-rafauzi.jpeg') }}" alt="Logo Rafauzi" style="width:100%; height:100%; object-fit:cover;">
        </a>
        <h1 class="auth-title" style="font-family:'Sora',sans-serif; font-size:24px; font-weight:700; color:#fff; margin-bottom:8px; letter-spacing:-0.5px;">Silahkan Mendaftar</h1>
        <p class="auth-subtitle" style="font-size:14px; color:#6e70a0;">Bergabung dengan ribuan pelanggan kami di seluruh Indonesia.</p>
    </div>

    <div class="auth-body">
        <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:16px;">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" style="display:block; font-size:13px; font-weight:500; color:#a5b4fc; margin-bottom:8px;">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe"
                       style="width: 100%; background: rgba(255,255,255,0.03); border: 0.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 14px 16px; color: #fff; font-size: 14px; outline: none; transition: 0.2s;"
                       onfocus="this.style.borderColor='#6366f1'; this.style.background='rgba(99,102,241,0.05)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.background='rgba(255,255,255,0.03)'">
                @error('name') <div class="input-error" style="color:#ef4444; font-size:12px; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" style="display:block; font-size:13px; font-weight:500; color:#a5b4fc; margin-bottom:8px;">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="contoh@email.com"
                       style="width: 100%; background: rgba(255,255,255,0.03); border: 0.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 14px 16px; color: #fff; font-size: 14px; outline: none; transition: 0.2s;"
                       onfocus="this.style.borderColor='#6366f1'; this.style.background='rgba(99,102,241,0.05)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.background='rgba(255,255,255,0.03)'">
                @error('email') <div class="input-error" style="color:#ef4444; font-size:12px; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" style="display:block; font-size:13px; font-weight:500; color:#a5b4fc; margin-bottom:8px;">Kata Sandi</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Min 8 karakter, kombinasi huruf & angka"
                       style="width: 100%; background: rgba(255,255,255,0.03); border: 0.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 14px 16px; color: #fff; font-size: 14px; outline: none; transition: 0.2s;"
                       onfocus="this.style.borderColor='#6366f1'; this.style.background='rgba(99,102,241,0.05)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.background='rgba(255,255,255,0.03)'"
                       oninput="checkStrength(this.value)">
                
                <!-- PASSWORD STRENGTH METER -->
                <div style="margin-top:10px; display:flex; gap:6px; height:4px;" id="strength-bars">
                    <div style="flex:1; background:rgba(255,255,255,0.1); border-radius:4px; transition:0.3s;" id="bar-1"></div>
                    <div style="flex:1; background:rgba(255,255,255,0.1); border-radius:4px; transition:0.3s;" id="bar-2"></div>
                    <div style="flex:1; background:rgba(255,255,255,0.1); border-radius:4px; transition:0.3s;" id="bar-3"></div>
                </div>
                <div id="strength-text" style="font-size:11px; margin-top:6px; color:#6e70a0; font-weight:500; text-align:right;"></div>

                @error('password') <div class="input-error" style="color:#ef4444; font-size:12px; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" style="display:block; font-size:13px; font-weight:500; color:#a5b4fc; margin-bottom:8px;">Konfirmasi Kata Sandi</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi"
                       style="width: 100%; background: rgba(255,255,255,0.03); border: 0.5px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 14px 16px; color: #fff; font-size: 14px; outline: none; transition: 0.2s;"
                       onfocus="this.style.borderColor='#6366f1'; this.style.background='rgba(99,102,241,0.05)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.background='rgba(255,255,255,0.03)'">
                @error('password_confirmation') <div class="input-error" style="color:#ef4444; font-size:12px; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <button type="submit" style="width: 100%; padding: 14px; border-radius: 12px; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; font-size: 15px; font-weight: 600; border: none; cursor: pointer; transition: 0.2s; margin-top: 8px;"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.opacity='0.9'"
                    onmouseout="this.style.transform='none'; this.style.opacity='1'">
                Daftar Akun Baru
            </button>

            <div style="text-align:center; font-size:13px; margin-top:4px;">
                <a href="{{ route('login') }}" style="color:#a5b4fc; text-decoration:none; transition:0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#a5b4fc'">Sudah Punya Akun? Masuk di sini.</a>
            </div>
        </form>
    </div>

    <!-- SCRIPT ESTIMASI KEKUATAN SANDI 3 BAR -->
    <script>
        function checkStrength(password) {
            let strength = 0;
            if (password.length > 0) strength += 1;
            if (password.length > 7 && password.match(/[a-zA-Z]/) && password.match(/\d/)) strength += 1;
            if (password.length >= 10 && password.match(/[^a-zA-Z\d]/)) strength += 1;

            const bars = [
                document.getElementById('bar-1'),
                document.getElementById('bar-2'),
                document.getElementById('bar-3')
            ];
            const text = document.getElementById('strength-text');

            // Reset
            bars.forEach(bar => bar.style.background = 'rgba(255,255,255,0.1)');

            if (password.length === 0) {
                text.innerText = '';
                return;
            }

            if (strength === 1) {
                bars[0].style.background = '#ef4444'; // Red
                text.innerText = 'Lemah';
                text.style.color = '#ef4444';
            } else if (strength === 2) {
                bars[0].style.background = '#f59e0b'; // Amber
                bars[1].style.background = '#f59e0b';
                text.innerText = 'Cukup / Sedang';
                text.style.color = '#f59e0b';
            } else if (strength >= 3) {
                bars[0].style.background = '#10b981'; // Green
                bars[1].style.background = '#10b981';
                bars[2].style.background = '#10b981';
                text.innerText = 'Sangat Kuat!';
                text.style.color = '#10b981';
            }
        }
    </script>
</x-guest-layout>
