@extends('layouts.pengguna')

@section('page-title', 'Pengaturan Akun')

@section('content')

<div style="max-width: 800px; margin: 0 auto; padding-bottom:40px;">

    {{-- HEADER --}}
    <div style="margin-bottom: 32px;">
      <h1 style="font-family:'Sora',sans-serif; font-size:24px; font-weight:700; color:#e8e9f5; letter-spacing:-0.5px;">
        Profil Saya 👤
      </h1>
      <p style="font-size:13.5px; color:#6e70a0; margin-top:4px;">
        Perbarui informasi profil, alamat pengiriman, dan keamanan akun Anda.
      </p>
    </div>

    <div style="display:flex; flex-direction:column; gap:24px;">
        
        <div class="content-card">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="content-card">
            @include('profile.partials.update-password-form')
        </div>

        <div class="content-card">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</div>

<style>
    .content-card {
        background: #10111a; border: 1px solid rgba(255,255,255,0.06);
        border-radius: 18px; padding: 32px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }
    .content-card h2 { font-family: 'Sora', sans-serif; color: #e8e9f5; margin-bottom: 8px; font-size:18px; }
    .content-card p { color: #8889a4; font-size: 13px; line-height: 1.6; }

    body.light-mode .content-card {
        background: #ffffff !important; border-color: rgba(0,0,0,0.08) !important;
    }
    body.light-mode .content-card h2 { color: #0f172a !important; }
    body.light-mode .content-card p { color: #475569 !important; }

    /* Form UI Override */
    .content-card label {
        color: #c4c5e8 !important; font-weight: 500 !important;
        font-size: 13.5px !important; margin-bottom: 6px !important; display: block !important;
    }
    .content-card input[type="text"],
    .content-card input[type="email"],
    .content-card input[type="password"],
    .content-card textarea {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.15) !important;
        color: #e8e9f5 !important;
        border-radius: 8px !important;
        padding: 10px 14px !important;
        width: 100% !important;
    }
    .content-card input:focus,
    .content-card textarea:focus {
        border-color: #6366f1 !important; outline: none !important;
        box-shadow: 0 0 0 2px rgba(99,102,241,0.2) !important;
    }

    body.light-mode .content-card label { color: #1e293b !important; }
    body.light-mode .content-card input,
    body.light-mode .content-card textarea {
        background: #ffffff !important; border: 1px solid rgba(0,0,0,0.15) !important;
        color: #0f172a !important;
    }
    body.light-mode .content-card input:focus,
    body.light-mode .content-card textarea:focus { border-color: #6366f1 !important; }
</style>

@endsection
