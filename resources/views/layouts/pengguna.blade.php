<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toko Parabot Rafauzi — @yield('page-title', 'Beranda')</title>
  <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-rafauzi.jpeg') }}">
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg:       #09090f;
      --surface:  #0f1018;
      --surface2: #14151f;
      --border:   rgba(255,255,255,0.07);
      --text:     #e8e9f5;
      --muted:    #6e70a0;
      --dim:      #3d3f52;
      --accent:   #6366f1;
      --accent2:  #8b5cf6;
      --green:    #4ade80;
      --red:      #f87171;
      --amber:    #fbbf24;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
    }

    /* ====== NAVBAR ====== */
    .navbar {
      position: sticky; top: 0; z-index: 100;
      background: rgba(9,9,15,0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 0.5px solid var(--border);
    }
    .navbar-inner {
      max-width: 1200px; margin: 0 auto;
      padding: 0 24px;
      height: 60px;
      display: flex; align-items: center; justify-content: space-between;
    }
    .nav-brand {
      display: flex; align-items: center; gap: 10px;
      text-decoration: none;
    }
    .nav-brand-icon {
      width: 32px; height: 32px;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 15px;
    }
    .nav-brand-name {
      font-family: 'Sora', sans-serif;
      font-size: 15px; font-weight: 600;
      color: var(--text);
      letter-spacing: -0.3px;
    }
    .nav-links {
      display: flex; align-items: center; gap: 4px;
    }
    .nav-link {
      display: flex; align-items: center; gap: 6px;
      padding: 7px 14px; border-radius: 8px;
      font-size: 13.5px; font-weight: 500; color: var(--muted);
      text-decoration: none;
      transition: background 0.15s, color 0.15s;
    }
    .nav-link:hover { background: rgba(255,255,255,0.05); color: var(--text); }
    .nav-link.active {
      background: rgba(99,102,241,0.12);
      color: #a5b4fc;
    }
    .nav-right {
      display: flex; align-items: center; gap: 10px;
    }
    .user-chip {
      display: flex; align-items: center; gap: 8px;
      padding: 4px 12px 4px 4px;
      background: rgba(255,255,255,0.04);
      border: 0.5px solid var(--border);
      border-radius: 20px;
    }
    .user-avatar {
      width: 28px; height: 28px; border-radius: 50%;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      display: flex; align-items: center; justify-content: center;
      font-size: 11px; font-weight: 700; color: #fff;
      font-family: 'Sora', sans-serif;
    }
    .user-name-text { font-size: 13px; font-weight: 500; color: var(--muted); }

    .btn-logout {
      padding: 7px 14px; border-radius: 8px;
      font-size: 13px; font-weight: 500; color: var(--red);
      background: rgba(248,113,113,0.08);
      border: 0.5px solid rgba(248,113,113,0.2);
      cursor: pointer; text-decoration: none;
      transition: background 0.15s;
    }
    .btn-logout:hover { background: rgba(248,113,113,0.15); }

    /* ====== PAGE CONTENT ====== */
    .page-wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 32px 24px;
    }

    /* ====== FLASH MESSAGES ====== */
    .flash-success {
      display: flex; align-items: center; gap: 10px;
      padding: 12px 16px; border-radius: 10px;
      font-size: 13px; font-weight: 500; margin-bottom: 20px;
      background: rgba(74,222,128,0.1);
      border: 0.5px solid rgba(74,222,128,0.2);
      color: var(--green);
    }
    .flash-error {
      display: flex; align-items: center; gap: 10px;
      padding: 12px 16px; border-radius: 10px;
      font-size: 13px; font-weight: 500; margin-bottom: 20px;
      background: rgba(248,113,113,0.1);
      border: 0.5px solid rgba(248,113,113,0.25);
      color: var(--red);
    }

    @media (max-width: 640px) {
      .nav-brand-name { display: none; }
      .user-name-text { display: none; }
      .page-wrap { padding: 20px 16px; }
    }

    @media (max-width: 768px) {
      .navbar-inner { flex-wrap: wrap; }
      .nav-links { order: 3; width: 100%; justify-content: center; margin-top: 10px; }
      .main-content { padding: 80px 16px 40px; }
    }

    /* --- LIGHT MODE SPECIFIC STYLES --- */
    body.light-mode {
      background-color: #f8fafc;
      color: #1e293b;
    }
    body.light-mode .navbar {
      background: rgba(255, 255, 255, 0.85);
      border-bottom: 1px solid rgba(0, 0, 0, 0.08);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }
    body.light-mode .nav-brand-name { color: #0f172a; }
    body.light-mode .nav-link { color: #64748b; }
    body.light-mode .nav-link:hover, body.light-mode .nav-link.active { color: #4b6bfb; background: rgba(75,107,251,0.08); }
    body.light-mode .nav-profile-name { color: #0f172a; }
    body.light-mode .dropdown-menu {
      background: #ffffff;
      border: 1px solid rgba(0,0,0,0.08);
      box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    body.light-mode .dropdown-item { color: #475569; }
    body.light-mode .dropdown-item:hover { background: #f1f5f9; color: #ef4444; }
    
    /* Custom Classes for inner views (dashboard, produk, riwayat) */
    body.light-mode .feature-card,
    body.light-mode .produk-card,
    body.light-mode .order-card {
      background-color: #ffffff !important;
      border-color: rgba(0,0,0,0.06) !important;
      box-shadow: 0 4px 16px rgba(0,0,0,0.03) !important;
    }
    body.light-mode .hero-section {
      background: linear-gradient(to bottom, #f1f5f9, #ffffff) !important;
      border-color: rgba(0,0,0,0.06) !important;
    }
    body.light-mode .hero-content h1,
    body.light-mode .feature-title,
    body.light-mode .order-id,
    body.light-mode .card-body > div:nth-child(2) {
      color: #0f172a !important;
    }
    body.light-mode .hero-content p,
    body.light-mode .feature-desc,
    body.light-mode .card-body > div:nth-child(3) {
      color: #475569 !important;
    }
    body.light-mode .btn-secondary {
      background: #ffffff !important; border-color: rgba(0,0,0,0.1) !important; color: #475569 !important;
    }
    body.light-mode .btn-secondary:hover { background: #f1f5f9 !important; }
    body.light-mode .order-header {
      background: #f8fafc !important; border-bottom: 0px !important;
    }
    body.light-mode .order-status-wrap,
    body.light-mode .order-thumb {
      background: #f1f5f9 !important; border-color: rgba(0,0,0,0.05) !important;
    }
    body.light-mode .card-img-wrap,
    body.light-mode .feature-icon {
      background: #f1f5f9 !important; border-color: rgba(0,0,0,0.05) !important;
    }
    body.light-mode .qty-input,
    body.light-mode #searchInput,
    body.light-mode #filterKat,
    body.light-mode [style*="background:rgba(255,255,255,0.04)"] {
      background: #ffffff !important;
      border-color: #cbd5e1 !important;
      color: #0f172a !important;
    }
    /* Miscellaneous Text Covers */
    body.light-mode .text-gray-400, body.light-mode [style*="color: #8889a4"], body.light-mode [style*="color:#6e70a0"], body.light-mode [style*="color:#3d3f52"] { color: #64748b !important; }
    body.light-mode .text-white, body.light-mode h1, body.light-mode h2, body.light-mode h3, body.light-mode [style*="color:#e8e9f5"], body.light-mode [style*="color:#d0d1e8"] { color: #0f172a !important; }
    body.light-mode .border-gray-700, body.light-mode [style*="border-color: rgba(255,255,255"] { border-color: rgba(0,0,0,0.1) !important; }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="navbar-inner">
    <a href="/pengguna/dashboard" class="nav-brand">
      <div class="nav-brand-icon" style="overflow:hidden;">
        <img src="{{ asset('images/logo-rafauzi.jpeg') }}" alt="Logo Rafauzi" style="width:100%;height:100%;object-fit:cover;">
      </div>
      <span class="nav-brand-name">Parabot Rafauzi</span>
    </a>

    <div class="nav-links">
      <a href="/produk-user"
         class="nav-link {{ request()->is('produk-user') ? 'active' : '' }}">
        🛍 Produk
      </a>
      <a href="/riwayat"
         class="nav-link {{ request()->is('riwayat') ? 'active' : '' }}">
        📋 Pesanan Saya
      </a>
    </div>

    <div class="nav-right">
      <!-- Theme Toggle Button -->
      <button id="theme-toggle" class="nav-link" style="background:none; border:none; padding:8px; margin-right:8px; cursor:pointer; display:flex; align-items:center;" onclick="toggleTheme()" aria-label="Toggle Theme">
        <span id="theme-icon" style="font-size:18px;">☀️</span>
      </button>

      <div style="position:relative;" id="profileContainer">
        <div class="profile-trigger" id="profileTrigger" onclick="toggleDropdown(event)" style="display:flex; align-items:center; gap:8px; cursor:pointer; padding:6px 12px 6px 6px; background:rgba(255,255,255,0.04); border:0.5px solid rgba(255,255,255,0.08); border-radius:30px; transition:0.2s;">
          <div class="user-avatar" style="width:28px; height:28px; border-radius:50%; background:linear-gradient(135deg,var(--accent),var(--accent2)); color:#fff; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700;">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
          </div>
          <span class="user-name-text" style="font-size:13px;font-weight:500;color:var(--text);">{{ auth()->user()->name }}</span>
          <span style="font-size:10px; color:var(--muted); margin-left:4px;">▼</span>
        </div>

        <div id="dropdownMenu" class="dropdown-menu" style="display:none; position:absolute; right:0; top:48px; background:#14151f; border:0.5px solid rgba(255,255,255,0.1); border-radius:12px; width:180px; box-shadow:0 12px 30px rgba(0,0,0,0.5); padding:8px; z-index:999;">
          <a href="/profile" class="dropdown-item" style="display:block; padding:10px 14px; color:#e8e9f5; text-decoration:none; font-size:13px; font-weight:500; border-radius:8px; margin-bottom:4px; transition:0.2s;">
            👤 Profil Saya
          </a>
          <hr style="border:0; border-top:0.5px solid rgba(255,255,255,0.05); margin:4px 0;">
          <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="dropdown-item" style="width:100%; text-align:left; background:none; border:none; padding:10px 14px; color:#f87171; font-size:13px; font-weight:500; border-radius:8px; cursor:pointer; transition:0.2s;">
              🚪 Keluar
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>

<div class="page-wrap">
  @if(session('success'))
    <div class="flash-success">✓ &nbsp;{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="flash-error">✕ &nbsp;{{ session('error') }}</div>
  @endif

  @yield('content')
</div>

</div>

<script>
  function applyTheme(isLight) {
    if (isLight) {
      document.body.classList.add('light-mode');
      document.getElementById('theme-icon').innerText = '🌙';
    } else {
      document.body.classList.remove('light-mode');
      document.getElementById('theme-icon').innerText = '☀️';
    }
  }

  function toggleTheme() {
    const isLight = !document.body.classList.contains('light-mode');
    localStorage.setItem('theme', isLight ? 'light' : 'dark');
    applyTheme(isLight);
  }

  document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light') {
      applyTheme(true);
    }
  });

  function toggleDropdown(e) {
    e.stopPropagation();
    const menu = document.getElementById('dropdownMenu');
    menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'block' : 'none';
  }

  // Tutup dropdown jika klik sembarang tempat
  document.addEventListener('click', function(event) {
    const isClickInside = document.getElementById('profileContainer').contains(event.target);
    if (!isClickInside) {
      document.getElementById('dropdownMenu').style.display = 'none';
    }
  });
</script>

</body>
</html>
