<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - e-Breeding BBPTUHPT Baturraden</title>
    <link rel="shortcut icon" href="/favicon.png">
    <link rel="stylesheet" href="/assets/styles/login.css">
</head>

<body>
    <div class="login-shell">
        <section class="login-left">
            <a href="/" class="brand-corner">
                <img src="/assets/images/logo-kementan.png" alt="Logo Kementerian Pertanian">
                <span>
                    <span class="brand-corner-name">e-Breeding</span>
                    <span class="brand-corner-sub">BBPTUHPT Baturraden</span>
                </span>
            </a>

            <div class="login-card">
                <div class="login-hero-head">
                    <div class="login-icon-badge" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" y1="12" x2="3" y2="12" />
                        </svg>
                    </div>
                    <h1 class="login-title">Masuk ke akun Anda!</h1>
                    <p class="login-subtitle">Masukkan username dan password terdaftar untuk login.</p>
                </div>

                <?php
                $err = $this->session->flashdata('pesan');
                if ($err != '') {
                    $isSuccess = (stripos($err, 'alert-success') !== false);
                ?>
                    <div class="login-alert<?php echo $isSuccess ? ' is-success' : ''; ?>" role="alert">
                        <?php echo $err; ?>
                    </div>
                <?php } ?>

                <?php if (isset($pesanerror) && $pesanerror != '') { ?>
                    <div class="login-alert" role="alert">
                        <?php echo $pesanerror; ?>
                    </div>
                <?php } ?>

                <form action="<?php echo site_url('/login/proses'); ?>" method="post" autocomplete="on">
                    <div class="form-field">
                        <label class="form-label" for="username">Username</label>
                        <div class="input-wrap">
                            <span class="input-icon-left" aria-hidden="true">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </span>
                            <input id="username" name="username" type="text" class="form-input" placeholder="Masukkan username" required autofocus>
                        </div>
                    </div>

                    <div class="form-field">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon-left" aria-hidden="true">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </span>
                            <input id="password" name="password" type="password" class="form-input" placeholder="Masukkan password" required>
                            <button type="button" class="toggle-pass-btn" id="togglePassword" aria-label="Tampilkan atau sembunyikan password">
                                <svg id="eyeIcon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-row-aux">
                        <label class="remember-label">
                            <input type="checkbox" id="rememberUser">
                            <span>Ingat username</span>
                        </label>
                        <a href="/" class="aux-link">Kembali ke Home</a>
                    </div>

                    <button type="submit" class="btn-login-submit" name="login" value="1">Masuk</button>
                </form>

                <div class="quick-divider">Akses Cepat</div>

                <div class="quick-actions">
                    <a href="/" class="quick-btn">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                        Beranda
                    </a>
                    <a href="/landingpage/analisa" class="quick-btn">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1d9742" stroke-width="2.2" stroke-linecap="round">
                            <line x1="6" y1="20" x2="6" y2="14" />
                            <line x1="12" y1="20" x2="12" y2="9" />
                            <line x1="18" y1="20" x2="18" y2="4" />
                        </svg>
                        e-Analisa
                    </a>
                </div>
            </div>
        </section>

        <section class="login-right-wrap">
            <div class="login-showcase">
                <h2 class="showcase-heading">Monitoring Ternak <span>Terpadu</span></h2>

                <div class="orbit-stage" aria-label="Modul ekosistem e-Breeding">
                    <span class="orbit-ring ring-1" aria-hidden="true"></span>
                    <span class="orbit-ring ring-2" aria-hidden="true"></span>
                    <span class="orbit-ring ring-3" aria-hidden="true"></span>

                    <div class="orbit-center">
                        <img src="/assets/images/bbptusp.png" alt="Logo BBPTUHPT Baturraden">
                    </div>

                    <div class="orbit-node is-emerald node-1" data-label="Produksi Susu" title="Produksi Susu">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 3h6v3l2 3v11a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V9l2-3V3z" />
                        </svg>
                    </div>

                    <div class="orbit-node is-gold node-2" data-label="Reproduksi &amp; IB" title="Reproduksi &amp; IB">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="14" r="4" />
                            <path d="M12 11l5-5m0 0h-4m4 0v4" />
                        </svg>
                    </div>

                    <div class="orbit-node node-3" data-label="Calving Interval" title="Calving Interval">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                    </div>

                    <div class="orbit-node is-emerald node-4" data-label="Kesehatan Ternak" title="Kesehatan Ternak">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            <path d="M9 12h6M12 9v6" />
                        </svg>
                    </div>

                    <div class="orbit-node node-5" data-label="e-Analisa" title="e-Analisa">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#1d9742" stroke-width="2.2" stroke-linecap="round">
                            <line x1="6" y1="20" x2="6" y2="14" />
                            <line x1="12" y1="20" x2="12" y2="9" />
                            <line x1="18" y1="20" x2="18" y2="4" />
                        </svg>
                    </div>

                    <div class="orbit-node is-gold node-6" data-label="Data Laktasi" title="Data Laktasi">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                        </svg>
                    </div>

                    <div class="orbit-node is-emerald node-7" data-label="Sertifikat Bibit" title="Sertifikat Bibit">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="9" r="6" />
                            <path d="m8.5 14-1.5 8 5-2.5 5 2.5-1.5-8" />
                        </svg>
                    </div>

                    <div class="orbit-node node-8" data-label="Multi Perangkat" title="Multi Perangkat">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="5" y="2" width="14" height="20" rx="2" ry="2" />
                            <line x1="12" y1="18" x2="12.01" y2="18" />
                        </svg>
                    </div>
                </div>

                <div class="showcase-footer">
                    <p class="showcase-caption" id="showcaseCaption">
                        Terintegrasi untuk pengelolaan <strong>Produksi Susu, Reproduksi, Kesehatan</strong>, dan <strong>Sertifikat Bibit Ternak</strong> BBPTUHPT Baturraden.
                    </p>
                    <div class="slide-dots" role="tablist" aria-label="Sorotan fitur">
                        <button type="button" class="slide-dot active" data-slide="0" aria-label="Sorotan 1"></button>
                        <button type="button" class="slide-dot" data-slide="1" aria-label="Sorotan 2"></button>
                        <button type="button" class="slide-dot" data-slide="2" aria-label="Sorotan 3"></button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        (function () {
            var userInput = document.getElementById('username');
            var passInput = document.getElementById('password');
            var toggleBtn = document.getElementById('togglePassword');
            var eyeIcon = document.getElementById('eyeIcon');
            var rememberCb = document.getElementById('rememberUser');

            try {
                var savedUser = localStorage.getItem('ebreeding_remember_user');
                if (savedUser && userInput) {
                    userInput.value = savedUser;
                    if (rememberCb) rememberCb.checked = true;
                }
            } catch (e) {}

            var form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function () {
                    try {
                        if (rememberCb && rememberCb.checked && userInput.value.trim() !== '') {
                            localStorage.setItem('ebreeding_remember_user', userInput.value.trim());
                        } else {
                            localStorage.removeItem('ebreeding_remember_user');
                        }
                    } catch (e) {}
                });
            }

            if (toggleBtn && passInput) {
                toggleBtn.addEventListener('click', function () {
                    var isHidden = passInput.type === 'password';
                    passInput.type = isHidden ? 'text' : 'password';
                    eyeIcon.innerHTML = isHidden
                        ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
                        : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
                });
            }

            var slides = [
                'Terintegrasi untuk pengelolaan <strong>Produksi Susu, Reproduksi, Kesehatan</strong>, dan <strong>Sertifikat Bibit Ternak</strong> BBPTUHPT Baturraden.',
                'Analisa performa sapi perah meliputi <strong>Calving Interval (CI), Service Per Conception (SC)</strong>, dan <strong>Days Open (DO)</strong>.',
                'Dapat diakses secara online melalui <strong>PC, Laptop, maupun Smartphone</strong> untuk pencatatan data breeding yang cepat.'
            ];
            var captionEl = document.getElementById('showcaseCaption');
            var dots = document.querySelectorAll('.slide-dot');
            var current = 0;

            function setSlide(idx) {
                current = idx;
                if (captionEl) captionEl.innerHTML = slides[idx];
                dots.forEach(function (d, i) {
                    d.classList.toggle('active', i === idx);
                });
            }

            dots.forEach(function (dot) {
                dot.addEventListener('click', function () {
                    setSlide(parseInt(dot.getAttribute('data-slide'), 10) || 0);
                });
            });

            setInterval(function () {
                setSlide((current + 1) % slides.length);
            }, 5500);
        })();
    </script>
</body>

</html>
