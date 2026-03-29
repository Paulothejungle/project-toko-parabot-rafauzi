<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toko Parabot Rafauzi</title>
  <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-rafauzi.jpeg') }}">
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #09090f; color: #e8e9f5;
      overflow-x: hidden;
    }

    /* ====== NAVBAR ====== */
    .navbar {
      position: fixed; top: 0; width: 100%; z-index: 1000;
      background: rgba(9,9,15,0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
      border-bottom: 0.5px solid rgba(255,255,255,0.07);
      transition: all 0.3s ease;
    }
    .nav-container {
      max-width: 1200px; margin: 0 auto; padding: 0 24px;
      height: 70px; display: flex; align-items: center; justify-content: space-between;
    }
    .brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .brand-icon {
      width: 36px; height: 36px; border-radius: 10px;
      overflow: hidden; display: flex; align-items: center; justify-content: center;
    }
    .brand-icon img { width: 100%; height: 100%; object-fit: cover; }
    .brand-text {
      font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 700;
      color: #fff; letter-spacing: -0.5px;
    }
    .nav-menu { display: flex; gap: 24px; align-items: center; }
    .nav-link {
      color: #a5b4fc; text-decoration: none; font-size: 14px; font-weight: 500;
      transition: color 0.2s;
    }
    .nav-link:hover { color: #fff; }
    .nav-actions { display: flex; gap: 12px; align-items: center; }
    .btn-login, .btn-register {
      padding: 8px 20px; border-radius: 10px; font-size: 14px; font-weight: 600;
      text-decoration: none; transition: all 0.2s;
    }
    .btn-login { color: #e8e9f5; }
    .btn-login:hover { color: #fff; background: rgba(255,255,255,0.05); }
    .btn-register {
      background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff;
    }
    .btn-register:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(99,102,241,0.25); }

    /* ====== HERO ====== */
    .hero {
      position: relative; min-height: 100vh;
      display: flex; align-items: center; justify-content: center;
      padding: 100px 24px 60px; text-align: center;
    }
    .hero-bg {
      position: absolute; inset: 0; z-index: -2;
      background-image: url('/images/toko-rafauzi.jpeg');
      background-size: cover; background-position: center; background-attachment: fixed;
    }
    .hero-overlay {
      position: absolute; inset: 0; z-index: -1;
      background: linear-gradient(to bottom, rgba(9,9,15,0.8) 0%, rgba(9,9,15,0.95) 100%);
    }
    .hero-content { max-width: 800px; }
    .badge-year {
      display: inline-block; padding: 6px 16px; border-radius: 30px;
      background: rgba(255,255,255,0.05); border: 0.5px solid rgba(255,255,255,0.1);
      color: #a5b4fc; font-size: 12px; font-weight: 600; letter-spacing: 1px;
      text-transform: uppercase; margin-bottom: 24px;
    }
    .hero-title {
      font-family: 'Sora', sans-serif; font-size: 56px; font-weight: 700;
      color: #fff; line-height: 1.1; letter-spacing: -1.5px; margin-bottom: 24px;
    }
    .hero-title span { background: linear-gradient(135deg, #6366f1, #8b5cf6, #d8b4fe); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .hero-desc {
      font-size: 18px; color: #a5a6c1; line-height: 1.6; margin-bottom: 40px;
      max-width: 600px; margin-left: auto; margin-right: auto;
    }
    .btn-explore {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 14px 32px; border-radius: 12px;
      background: #fff; color: #09090f; font-size: 16px; font-weight: 700;
      text-decoration: none; transition: transform 0.2s, background 0.2s;
    }
    .btn-explore:hover { transform: translateY(-3px); background: #e8e9f5; }

    /* ====== SECTION STYLES ====== */
    section { padding: 100px 24px; position: relative; }
    .section-container { max-width: 1200px; margin: 0 auto; }
    .section-title {
      font-family: 'Sora', sans-serif; font-size: 36px; font-weight: 700;
      color: #fff; margin-bottom: 16px; text-align: center;
    }
    .section-subtitle {
      font-size: 15px; color: #8889a4; text-align: center; max-width: 600px;
      margin: 0 auto 60px; line-height: 1.6;
    }

    /* ====== TENTANG KAMI ====== */
    .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
    .about-img {
      width: 100%; aspect-ratio: 4/3; border-radius: 24px;
      background: url('/images/toko-rafauzi.jpeg') center/cover;
      border: 0.5px solid rgba(255,255,255,0.1);
    }
    .about-text h3 {
      font-family: 'Sora', sans-serif; font-size: 28px; color: #fff; margin-bottom: 20px;
    }
    .about-text p {
      font-size: 15px; color: #a5a6c1; line-height: 1.8; margin-bottom: 20px;
    }
    .feature-list { display: flex; flex-direction: column; gap: 16px; margin-top: 30px; }
    .feature-item { display: flex; align-items: center; gap: 12px; }
    .feature-check {
      width: 24px; height: 24px; border-radius: 6px; background: rgba(99,102,241,0.1);
      color: #8b5cf6; display: flex; align-items: center; justify-content: center; font-size: 12px;
    }

    /* ====== KONTAK & LOKASI ====== */
    .contact-bg { background: rgba(255,255,255,0.02); border-top: 0.5px solid rgba(255,255,255,0.05); }
    .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
    .map-wrap {
      width: 100%; height: 450px; border-radius: 20px; overflow: hidden;
      border: 0.5px solid rgba(255,255,255,0.1);
    }
    .map-wrap iframe { width: 100%; height: 100%; object-fit: cover; }
    .feedback-form {
      background: #13151f; border: 0.5px solid rgba(255,255,255,0.07);
      padding: 40px; border-radius: 20px;
    }
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 13px; color: #a5b4fc; margin-bottom: 8px; font-weight: 500; }
    .form-input, .form-textarea {
      width: 100%; padding: 14px 16px; border-radius: 12px; background: rgba(255,255,255,0.03);
      border: 0.5px solid rgba(255,255,255,0.08); color: #fff; font-size: 14.5px;
      font-family: 'Plus Jakarta Sans', sans-serif; transition: border-color 0.2s; outline: none;
    }
    .form-input:focus, .form-textarea:focus { border-color: #6366f1; }
    .form-textarea { height: 120px; resize: vertical; }
    .btn-submit {
      width: 100%; padding: 14px; border-radius: 12px; background: linear-gradient(135deg, #6366f1, #8b5cf6);
      color: #fff; font-size: 15px; font-weight: 600; border: none; cursor: pointer;
      font-family: 'Plus Jakarta Sans', sans-serif; transition: opacity 0.2s, transform 0.2s;
    }
    .btn-submit:hover { opacity: 0.9; transform: translateY(-2px); }

    /* ====== FOOTER ====== */
    .footer {
      border-top: 0.5px solid rgba(255,255,255,0.05);
      padding: 60px 24px 30px; text-align: center;
    }
    .social-links { display: flex; justify-content: center; gap: 16px; margin: 30px 0; }
    .social-link {
      width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.04);
      border: 0.5px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center;
      color: #a5b4fc; text-decoration: none; font-size: 18px; transition: all 0.2s;
    }
    .social-link:hover { background: #6366f1; color: #fff; border-color: #6366f1; transform: translateY(-3px); }
    .copyright { font-size: 13px; color: #6e70a0; }

    @media (max-width: 768px) {
      .nav-menu { display: none; }
      .hero-title { font-size: 40px; }
      .about-grid, .contact-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="nav-container">
      <a href="/" class="brand">
        <div class="brand-icon">
          <img src="{{ asset('images/logo-rafauzi.jpeg') }}" alt="Logo Toko Parabot Rafauzi">
        </div>
        <div class="brand-text">Parabot Rafauzi</div>
      </a>
      <div class="nav-menu">
        <a href="#beranda" class="nav-link">Beranda</a>
        <a href="#tentang" class="nav-link">Tentang Kami</a>
        <a href="#lokasi" class="nav-link">Lokasi</a>
        <a href="#kontak" class="nav-link">Kontak</a>
      </div>
      <div class="nav-actions">
        @if (Route::has('login'))
          @auth
            <a href="{{ url('/dashboard') }}" class="btn-register">Dashboard</a>
          @else
            <a href="{{ route('login') }}" class="btn-login">Log in</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="btn-register">Daftar</a>
            @endif
          @endauth
        @endif
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section id="beranda" class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <div class="badge-year">Berdiri Sejak 2008</div>
      <h1 class="hero-title">Melengkapi Keindahan <span>Rumah Anda</span></h1>
      <p class="hero-desc">
        Temukan berbagai pilihan perabotan rumah tangga berkualitas unggul yang siap mempercantik ruang hidup Anda. Layanan terpercaya dari Toko Parabot Rafauzi.
      </p>
      <a href="{{ route('login') }}" class="btn-explore">
        🛍 Mulai Belanja
      </a>
    </div>
  </section>

  <!-- TENTANG KAMI -->
  <section id="tentang">
    <div class="section-container">
      <div class="about-grid">
        <div class="about-img"></div>
        <div class="about-text">
          <div style="font-size:12px; color:#a5b4fc; font-weight:700; letter-spacing:1px; text-transform:uppercase; margin-bottom:12px;">Profil Kami</div>
          <h3>Solusi Perabotan Terbaik Anda</h3>
          <p>
            Toko Parabot Rafauzi telah berdiri sejak tahun 2008 dan terus berkomitmen untuk menghadirkan perabotan rumah tangga dengan kualitas terbaik dan harga yang bersaing di pasaran.
          </p>
          <p>
            Dengan dedikasi melayani jutaan keluarga, kami memastikan kepuasan Anda adalah prioritas utama. Mulai dari perabotan ruang tamu, kamar, hingga dapur.
          </p>
          <div class="feature-list">
            <div class="feature-item">
              <div class="feature-check">✓</div>
              <span style="font-size:14.5px; color:#d0d1e8; font-weight:500;">Pengiriman Cepat Seluruh Indonesia</span>
            </div>
            <div class="feature-item">
              <div class="feature-check">✓</div>
              <span style="font-size:14.5px; color:#d0d1e8; font-weight:500;">Bahan dan Kualitas Terjamin</span>
            </div>
            <div class="feature-item">
              <div class="feature-check">✓</div>
              <span style="font-size:14.5px; color:#d0d1e8; font-weight:500;">Dukungan Pelanggan Prima</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- LOKASI & KONTAK -->
  <section id="lokasi" class="contact-bg">
    <div class="section-container">
      <h2 class="section-title">Temukan Kami</h2>
      <p class="section-subtitle">
        Kunjungi gerai fisik kami secara langsung atau kirimkan masukan Anda melalui form feedback di bawah ini. Kami selalu siap melayani Anda.
      </p>

      <div class="contact-grid">
        <!-- Google Maps -->
        <div>
          <div style="margin-bottom:20px;">
            <h4 style="font-family:'Sora',sans-serif; font-size:18px; color:#e8e9f5; margin-bottom:8px;">Toko Parabot Rafauzi</h4>
            <p style="font-size:14px; color:#8889a4; line-height:1.6;">
              📍 Jl. Rambutan 8 no 24 RT 04 RW 18, Kutabumi, Pasarkemis, Tangerang, Banten.
            </p>
          </div>
          <div class="map-wrap">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.804489082714!2d106.56038287409542!3d-6.156934160344012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ff93ca47b489%3A0x63fa9f83b01ce0d!2sTOKO%20RAFAUZI!5e0!3m2!1sid!2sid!4v1774507595281!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>

        <!-- Form Feedback -->
        <div id="kontak" class="feedback-form">
          <h4 style="font-family:'Sora',sans-serif; font-size:22px; color:#fff; margin-bottom:8px;">Beri Kami Masukan</h4>
          <p style="font-size:13.5px; color:#6e70a0; margin-bottom:28px;">Saran dan kritik Anda sangat berarti untuk meningkatkan kualitas layanan kami.</p>

          <form action="#" method="GET" onsubmit="alert('Terima kasih atas feedback Anda!'); this.reset(); return false;">
            <div class="form-group">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" class="form-input" placeholder="Masukkan nama..." required>
            </div>
            <div class="form-group">
              <label class="form-label">Email atau No. HP</label>
              <input type="text" class="form-input" placeholder="Kontak Anda..." required>
            </div>
            <div class="form-group">
              <label class="form-label">Pesan / Feedback</label>
              <textarea class="form-textarea" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
            </div>
            <button type="submit" class="btn-submit">✈ Kirim Pesan</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="brand" style="justify-content:center; margin-bottom:16px;">
      <div class="brand-icon" style="width:30px; height:30px; border-radius:8px; overflow:hidden;">
        <img src="{{ asset('images/logo-rafauzi.jpeg') }}" alt="Logo Rafauzi" style="width:100%;height:100%;object-fit:cover;">
      </div>
      <div class="brand-text" style="font-size:16px;">Toko Parabot Rafauzi</div>
    </div>
    <div style="font-size:14px; color:#8889a4;">
      Melengkapi Keindahan Rumah Anda Sejak 2008.
    </div>

    <div class="social-links">
      <a href="https://wa.me/6283146099905" target="_blank" class="social-link" title="WhatsApp 083146099905">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" /><path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" /></svg>
      </a>
      <a href="https://instagram.com/parabot_rafauzi?igsh=MW9qcjg4Y253dTZ3cQ==" target="_blank" class="social-link" title="Instagram @parabot_rafauzi">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 4a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" /><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M16.5 7.5l0 .01" /></svg>
      </a>
      <a href="https://instagram.com/parabot_rafauzi?igsh=MW9qcjg4Y253dTZ3cQ==" target="_blank" class="social-link" title="Facebook Parabot Rafauzi">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg>
      </a>
    </div>

    <div class="copyright">
      &copy; {{ date('Y') }} Toko Parabot Rafauzi. All rights reserved.
    </div>
  </footer>

</body>
</html>
