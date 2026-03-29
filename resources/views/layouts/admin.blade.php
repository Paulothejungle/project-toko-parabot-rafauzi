<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Admin</title>
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
      width: 240px;
      min-width: 240px;
      height: 100vh;
      background: #13151f;
      display: flex;
      flex-direction: column;
      border-right: 0.5px solid rgba(255,255,255,0.06);
      transition: width 0.3s ease, min-width 0.3s ease;
      overflow: hidden;
      position: fixed;
      top: 0; left: 0;
      z-index: 50;
    }

    #sidebar.collapsed { width: 72px; min-width: 72px; }
    #sidebar.collapsed .menu-text { display: none; }
    #sidebar.collapsed .sidebar-brand-text { display: none; }
    #sidebar.collapsed .sidebar-brand { justify-content: center; }
    #sidebar.collapsed .section-label { visibility: hidden; }

    .sidebar-brand {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 20px 16px;
      border-bottom: 0.5px solid rgba(255,255,255,0.05);
    }

    .brand-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }

    .brand-icon {
      width: 34px; height: 34px;
      background: linear-gradient(135deg, #6366f1, #8b5cf6);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }

    .brand-icon svg {
      width: 17px; height: 17px;
      stroke: white; fill: none;
      stroke-width: 2; stroke-linecap: round;
    }

    .sidebar-brand-text {
      font-family: 'Sora', sans-serif;
      font-size: 14px;
      font-weight: 600;
      color: #f0f0f5;
      letter-spacing: -0.3px;
      white-space: nowrap;
    }

    .toggle-btn {
      width: 28px; height: 28px;
      background: rgba(255,255,255,0.05);
      border: 0.5px solid rgba(255,255,255,0.1);
      border-radius: 6px;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      color: #666; font-size: 14px;
      flex-shrink: 0;
    }
    .toggle-btn:hover { background: rgba(255,255,255,0.1); color: #bbb; }

    .sidebar-nav {
      flex: 1;
      padding: 8px;
      display: flex;
      flex-direction: column;
      gap: 2px;
      overflow-y: auto;
    }

    .section-label {
      font-size: 10px;
      font-weight: 500;
      letter-spacing: 1.2px;
      color: #3d3f52;
      text-transform: uppercase;
      padding: 14px 8px 6px;
      white-space: nowrap;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 10px;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.15s;
      text-decoration: none;
      position: relative;
      white-space: nowrap;
    }

    .nav-item:hover { background: rgba(255,255,255,0.05); }
    .nav-item:hover .nav-label { color: #b0b1cc; }

    .nav-item.active { background: rgba(99,102,241,0.15); }
    .nav-item.active .nav-label { color: #c4c5e8; font-weight: 500; }
    .nav-item.active::after {
      content: '';
      position: absolute;
      right: 0; top: 50%;
      transform: translateY(-50%);
      width: 3px; height: 18px;
      background: #6366f1;
      border-radius: 2px 0 0 2px;
    }

    .nav-icon {
      width: 32px; height: 32px;
      border-radius: 7px;
      display: flex; align-items: center; justify-content: center;
      font-size: 15px;
      flex-shrink: 0;
      background: rgba(255,255,255,0.04);
    }

    .nav-item.active .nav-icon { background: rgba(99,102,241,0.2); }

    .nav-label {
      font-size: 13.5px;
      font-weight: 400;
      color: #8889a4;
    }

    .sidebar-footer {
      padding: 8px;
      border-top: 0.5px solid rgba(255,255,255,0.05);
    }

    .nav-item.logout:hover { background: rgba(239,68,68,0.1); }
    .nav-item.logout:hover .nav-label { color: #f87171; }

    /* MAIN LAYOUT */
    .main-wrap {
      display: flex;
      min-height: 100vh;
    }

    .sidebar-spacer {
      width: 240px;
      min-width: 240px;
      flex-shrink: 0;
      transition: width 0.3s ease, min-width 0.3s ease;
    }

    .main-content { flex: 1; display: flex; flex-direction: column; }

    /* TOPBAR */
    .topbar {
      position: sticky; top: 0; z-index: 40;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 24px;
      height: 56px;
      background: #13151f;
      border-bottom: 0.5px solid rgba(255,255,255,0.06);
    }

    .topbar-left { display: flex; align-items: center; gap: 12px; }

    .mobile-toggle {
      display: none;
      width: 32px; height: 32px;
      background: rgba(255,255,255,0.05);
      border: 0.5px solid rgba(255,255,255,0.1);
      border-radius: 7px;
      cursor: pointer;
      align-items: center; justify-content: center;
      color: #888;
    }

    .breadcrumb {
      font-size: 13px;
      color: #4a4c6a;
    }
    .breadcrumb span { color: #6e70a0; }

    .topbar-right { display: flex; align-items: center; gap: 8px; }

    .icon-btn {
      width: 32px; height: 32px;
      border-radius: 8px;
      background: rgba(255,255,255,0.04);
      border: 0.5px solid rgba(255,255,255,0.08);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; color: #555; font-size: 14px;
    }
    .icon-btn:hover { background: rgba(255,255,255,0.08); color: #aaa; }

    .user-badge {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 4px 10px 4px 4px;
      background: rgba(255,255,255,0.04);
      border: 0.5px solid rgba(255,255,255,0.08);
      border-radius: 20px;
    }

    .user-avatar {
      width: 26px; height: 26px;
      border-radius: 50%;
      background: linear-gradient(135deg, #6366f1, #8b5cf6);
      display: flex; align-items: center; justify-content: center;
      font-size: 10px;
      font-weight: 600;
      color: #fff;
      font-family: 'Sora', sans-serif;
    }

    .user-name {
      font-size: 13px;
      font-weight: 500;
      color: #8889a4;
    }

    /* PAGE CONTENT */
    .page-inner {
      padding: 28px 28px;
      flex: 1;
    }

    @media (max-width: 768px) {
      #sidebar { transform: translateX(-100%); }
      #sidebar.mobile-open { transform: translateX(0); }
      .sidebar-spacer { display: none; }
      .mobile-toggle { display: flex; }
    }
  </style>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const spacer = document.getElementById('sidebar-spacer');
      sidebar.classList.toggle('collapsed');
      if (spacer) {
        spacer.style.width = sidebar.classList.contains('collapsed') ? '72px' : '240px';
        spacer.style.minWidth = spacer.style.width;
      }
    }

    function toggleMobile() {
      document.getElementById('sidebar').classList.toggle('mobile-open');
    }
  </script>
</head>

<body>
<div class="main-wrap">

  <!-- SIDEBAR -->
  <aside id="sidebar">

    <div class="sidebar-brand">
      <a href="/admin/dashboard" class="brand-logo">
        <div class="brand-icon" style="background:none; overflow:hidden;">
          <img src="{{ asset('images/logo-rafauzi.jpeg') }}" alt="Logo Rafauzi" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <span class="sidebar-brand-text">Admin Panel</span>
      </a>
      <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    </div>

    <nav class="sidebar-nav">

      <div class="section-label menu-text">Utama</div>

      <a href="/admin/dashboard"
         class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <div class="nav-icon">📊</div>
        <span class="nav-label menu-text">Dashboard</span>
      </a>

      <div class="section-label menu-text" style="margin-top: 8px;">Manajemen</div>

      <a href="/kategori"
         class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
        <div class="nav-icon">📁</div>
        <span class="nav-label menu-text">Kategori</span>
      </a>

      <a href="/produk"
         class="nav-item {{ request()->is('produk*') ? 'active' : '' }}">
        <div class="nav-icon">📦</div>
        <span class="nav-label menu-text">Produk</span>
      </a>

      <a href="/transaksi"
         class="nav-item {{ request()->is('transaksi*') ? 'active' : '' }}">
        <div class="nav-icon">💳</div>
        <span class="nav-label menu-text">Transaksi</span>
      </a>

      <a href="/admin/pelanggan"
         class="nav-item {{ request()->is('admin/pelanggan*') ? 'active' : '' }}">
        <div class="nav-icon">👥</div>
        <span class="nav-label menu-text">Pelanggan</span>
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

  <!-- SPACER (geser konten saat sidebar terbuka) -->
  <div id="sidebar-spacer" class="sidebar-spacer"></div>

  <!-- MAIN -->
  <div class="main-content">

    <!-- TOPBAR -->
    <header class="topbar">
      <div class="topbar-left">
        <button class="mobile-toggle" onclick="toggleMobile()">☰</button>
        <div class="breadcrumb">
          Admin <span>/ @yield('page-title', 'Dashboard')</span>
        </div>
      </div>
      <div class="topbar-right">
        <div class="icon-btn" title="Notifikasi">🔔</div>
        <div class="icon-btn" title="Pengaturan">⚙</div>
        <div class="user-badge">
          <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
          </div>
          <span class="user-name">{{ auth()->user()->name }}</span>
        </div>
      </div>
    </header>

    <!-- KONTEN -->
    <main class="page-inner">
      @yield('content')
    </main>

  </div>

</div>
</body>
</html>