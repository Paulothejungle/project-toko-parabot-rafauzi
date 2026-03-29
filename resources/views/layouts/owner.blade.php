<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Owner - Toko Parabot Rafauzi</title>
  <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-rafauzi.jpeg') }}">
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Sora:wght@400;600&display=swap" rel="stylesheet">

  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #0f1117;
      color: #e8e9f5;
    }

    #sidebar {
      width: 220px; min-width: 220px;
      height: 100vh;
      background: #13151f;
      display: flex; flex-direction: column;
      border-right: 0.5px solid rgba(255,255,255,0.06);
      position: fixed; top: 0; left: 0; z-index: 50;
      transition: width 0.3s, min-width 0.3s;
      overflow: hidden;
    }
    #sidebar.collapsed { width: 64px; min-width: 64px; }
    #sidebar.collapsed .menu-text,
    #sidebar.collapsed .sidebar-brand-text { display: none; }
    #sidebar.collapsed .sidebar-brand { justify-content: center; }

    .sidebar-brand {
      display: flex; align-items: center; justify-content: space-between;
      padding: 18px 14px;
      border-bottom: 0.5px solid rgba(255,255,255,0.05);
    }
    .brand-logo { display: flex; align-items: center; gap: 9px; text-decoration: none; }
    .brand-icon {
      width: 32px; height: 32px;
      background: linear-gradient(135deg, #f59e0b, #ef4444);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 15px; flex-shrink: 0;
    }
    .sidebar-brand-text {
      font-family: 'Sora', sans-serif; font-size: 13.5px;
      font-weight: 600; color: #f0f0f5; white-space: nowrap;
    }
    .toggle-btn {
      width: 26px; height: 26px;
      background: rgba(255,255,255,0.05);
      border: 0.5px solid rgba(255,255,255,0.1);
      border-radius: 6px; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      color: #666; font-size: 13px; flex-shrink: 0;
    }
    .toggle-btn:hover { background: rgba(255,255,255,0.1); color: #bbb; }

    .sidebar-nav { flex: 1; padding: 8px; display: flex; flex-direction: column; gap: 2px; overflow-y: auto; }

    .section-label {
      font-size: 10px; font-weight: 500; letter-spacing: 1px;
      color: #3d3f52; text-transform: uppercase; padding: 12px 8px 5px;
    }
    .nav-item {
      display: flex; align-items: center; gap: 9px;
      padding: 9px 10px; border-radius: 8px; cursor: pointer;
      transition: background 0.15s; text-decoration: none;
      white-space: nowrap; position: relative;
    }
    .nav-item:hover { background: rgba(255,255,255,0.05); }
    .nav-item:hover .nav-label { color: #b0b1cc; }
    .nav-item.active { background: rgba(245,158,11,0.12); }
    .nav-item.active .nav-label { color: #fcd34d; font-weight: 500; }
    .nav-item.active::after {
      content:''; position:absolute; right:0; top:50%; transform:translateY(-50%);
      width:3px; height:16px; background:#f59e0b; border-radius:2px 0 0 2px;
    }
    .nav-icon {
      width: 30px; height: 30px; border-radius: 7px;
      display: flex; align-items: center; justify-content: center;
      font-size: 14px; flex-shrink: 0;
      background: rgba(255,255,255,0.04);
    }
    .nav-item.active .nav-icon { background: rgba(245,158,11,0.15); }
    .nav-label { font-size: 13px; font-weight: 400; color: #8889a4; }

    .sidebar-footer { padding: 8px; border-top: 0.5px solid rgba(255,255,255,0.05); }
    .nav-item.logout:hover { background: rgba(239,68,68,0.1); }
    .nav-item.logout:hover .nav-label { color: #f87171; }

    .main-wrap { display: flex; min-height: 100vh; }
    .sidebar-spacer { width: 220px; min-width: 220px; flex-shrink: 0; transition: width 0.3s, min-width 0.3s; }
    .main-content { flex: 1; display: flex; flex-direction: column; }

    .topbar {
      position: sticky; top: 0; z-index: 40;
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 24px; height: 54px;
      background: #13151f;
      border-bottom: 0.5px solid rgba(255,255,255,0.06);
    }
    .breadcrumb { font-size: 13px; color: #4a4c6a; }
    .breadcrumb span { color: #6e70a0; }
    .topbar-right { display: flex; align-items: center; gap: 8px; }
    .user-badge {
      display: flex; align-items: center; gap: 7px;
      padding: 3px 10px 3px 3px;
      background: rgba(255,255,255,0.04);
      border: 0.5px solid rgba(255,255,255,0.08);
      border-radius: 20px;
    }
    .user-avatar {
      width: 26px; height: 26px; border-radius: 50%;
      background: linear-gradient(135deg, #f59e0b, #ef4444);
      display: flex; align-items: center; justify-content: center;
      font-size: 10px; font-weight: 600; color: #fff; font-family: 'Sora', sans-serif;
    }
    .user-name { font-size: 13px; font-weight: 500; color: #8889a4; }
    .page-inner { padding: 28px; flex: 1; }

    .flash-success {
      display: flex; align-items: center; gap: 10px;
      padding: 12px 16px; border-radius: 10px;
      font-size: 13px; font-weight: 500; margin-bottom: 20px;
      background: rgba(74,222,128,0.1);
      border: 0.5px solid rgba(74,222,128,0.2); color: #4ade80;
    }
    .flash-error {
      display: flex; align-items: center; gap: 10px;
      padding: 12px 16px; border-radius: 10px;
      font-size: 13px; font-weight: 500; margin-bottom: 20px;
      background: rgba(248,113,113,0.1);
      border: 0.5px solid rgba(248,113,113,0.25); color: #f87171;
    }
  </style>

  <script>
    function toggleSidebar() {
      const sb = document.getElementById('sidebar');
      const sp = document.getElementById('sidebar-spacer');
      sb.classList.toggle('collapsed');
      if (sp) {
        const w = sb.classList.contains('collapsed') ? '64px' : '220px';
        sp.style.width = w; sp.style.minWidth = w;
      }
    }
  </script>
</head>
<body>
<div class="main-wrap">

  <aside id="sidebar">
    <div class="sidebar-brand">
      <a href="/owner/dashboard" class="brand-logo">
        <div class="brand-icon" style="background:none; overflow:hidden;">
          <img src="{{ asset('images/logo-rafauzi.jpeg') }}" alt="Logo Rafauzi" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <span class="sidebar-brand-text">Owner Panel</span>
      </a>
      <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    </div>

    <nav class="sidebar-nav">
      <div class="section-label menu-text">Laporan</div>

      <a href="/laporan"
         class="nav-item {{ request()->is('laporan') ? 'active' : '' }}">
        <div class="nav-icon">📊</div>
        <span class="nav-label menu-text">Laporan Penjualan</span>
      </a>

      <a href="/laporan/stok"
         class="nav-item {{ request()->is('laporan/stok') ? 'active' : '' }}">
        <div class="nav-icon">📦</div>
        <span class="nav-label menu-text">Laporan Stok</span>
      </a>
    </nav>

    <div class="sidebar-footer">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-item logout" style="width:100%;border:none;background:none;cursor:pointer;">
          <div class="nav-icon">🚪</div>
          <span class="nav-label menu-text">Logout</span>
        </button>
      </form>
    </div>
  </aside>

  <div id="sidebar-spacer" class="sidebar-spacer"></div>

  <div class="main-content">
    <header class="topbar">
      <div class="breadcrumb">
        Owner <span>/ @yield('page-title', 'Dashboard')</span>
      </div>
      <div class="topbar-right">
        <div class="user-badge">
          <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
          </div>
          <span class="user-name">{{ auth()->user()->name }}</span>
        </div>
      </div>
    </header>

    <main class="page-inner">
      @if(session('success'))
        <div class="flash-success">✓ &nbsp;{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="flash-error">✕ &nbsp;{{ session('error') }}</div>
      @endif

      @yield('content')
    </main>
  </div>

</div>
</body>
</html>
