<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>e-Breeding BBPTUHPT Baturraden</title>
    <link rel="stylesheet" href="/assets/styles/landing.css?v=<?php echo @filemtime(FCPATH . 'assets/styles/landing.css') ?: '2'; ?>">
</head>

<body>
    <div class="viewport-shell">
        <header class="topbar">
            <div class="brand-group">
                <a href="/" class="brand-mark">
                    <span class="brand-emblem" aria-hidden="true">
                        <img src="/assets/images/logo-kementan.png" alt="Logo Kementerian Pertanian" style="width: 40px; height: 40px; object-fit: contain; display: block;">
                    </span>
                    <span>
                        <span class="brand-name">e-Breeding</span>
                        <span class="brand-sub">BBPTUHPT Baturraden</span>
                    </span>
                </a>
                <span class="brand-divider" aria-hidden="true"></span>
            </div>

            <nav class="main-nav" id="mainNav" aria-label="Navigasi utama">
                <ul class="nav-links">
                    <li><a href="/" class="active">Home</a></li>
                    <li><a href="/landingpage/analisa">e-Analisa</a></li>
                    <li><button type="button" data-modal-open="fitur">Fitur</button></li>
                    <li><button type="button" data-modal-open="tentang">Tentang</button></li>
                    <li><a href="/login">e-Breeding</a></li>
                </ul>
            </nav>

            <div class="nav-actions">
                <a href="/landingpage/analisa" class="icon-btn" title="Buka e-Analisa" aria-label="Buka e-Analisa">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3v18h18" />
                        <path d="m19 9-5 5-4-4-3 3" />
                    </svg>
                </a>
                <a href="/login" class="icon-btn" title="Masuk e-Breeding" aria-label="Masuk e-Breeding">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                </a>
                <button type="button" class="icon-btn menu-toggle" id="menuToggle" aria-label="Buka menu navigasi" aria-controls="mainNav" aria-expanded="false">
                    <svg class="icon-hamburger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                        <line x1="4" y1="7" x2="20" y2="7" />
                        <line x1="4" y1="12" x2="20" y2="12" />
                        <line x1="4" y1="17" x2="20" y2="17" />
                    </svg>
                    <svg class="icon-close" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                        <line x1="6" y1="6" x2="18" y2="18" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                    </svg>
                </button>
            </div>
        </header>

        <main class="hero-main">
            <section class="hero-copy">
                <h1 class="hero-title">
                    Data <span class="gold-word">breeding</span><br>
                    untuk ternak<br>
                    perah unggul
                </h1>
                <div class="title-accent-bar" aria-hidden="true"></div>
                <p class="hero-desc">
                    e-Breeding mengelola produktivitas, reproduksi, kesehatan, hingga penerbitan sertifikat bibit ternak secara terpadu. Dapat diakses melalui PC, laptop, maupun smartphone.
                </p>

                <div class="hero-cta-row">
                    <a href="/login" class="btn-primary-pill">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" />
                            <polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none" />
                        </svg>
                        Masuk e-Breeding
                    </a>
                    <a href="/landingpage/analisa" class="btn-secondary-pill">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                            <line x1="6" y1="20" x2="6" y2="14" />
                            <line x1="12" y1="20" x2="12" y2="9" />
                            <line x1="18" y1="20" x2="18" y2="4" />
                        </svg>
                        Buka e-Analisa
                    </a>
                </div>
            </section>

            <section class="hero-stage" aria-label="Pratinjau ekosistem e-Breeding">
                <svg class="stage-orbit" viewBox="0 0 600 460" fill="none" aria-hidden="true">
                    <circle cx="320" cy="230" r="196" stroke="url(#orbitGrad)" stroke-width="2" opacity="0.45" />
                    <circle cx="320" cy="230" r="228" stroke="#dcfce7" stroke-width="1.5" opacity="0.8" />
                    <defs>
                        <linearGradient id="orbitGrad" x1="120" y1="120" x2="480" y2="340" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#16a34a" />
                            <stop offset="0.55" stop-color="#eab308" />
                            <stop offset="1" stop-color="#bbf7d0" />
                        </linearGradient>
                    </defs>
                </svg>

                <div class="cow-node" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M5 9c-1.5 0-2.5.9-2.8 2.2L1.5 14h2l.6-2h1.4l.8 4.5H8l-.4-3.5h6.8L14 16.5h1.7l.7-4.5h1.8l1.2 1.8 1.5-.9-1.5-2.6c-.4-.8-1.2-1.3-2.1-1.3H5zm13.8-2.5c-.6 0-1.2.4-1.5.9l-.8 1.2h3.1l.9-1.1c.4-.5 0-1-.7-1z" />
                    </svg>
                </div>

                <div class="photo-tile tile-tl">
                    <img src="/assets/images/gb1.jpg" alt="Kawasan Gunung Slamet Baturraden">
                    <span class="tile-label">Baturraden</span>
                </div>

                <div class="photo-tile tile-bl">
                    <img src="/assets/images/gb3.jpg" alt="Padang penggembalaan sapi perah">
                    <span class="tile-label">Pastura</span>
                </div>

                <div class="photo-tile tile-tr">
                    <img src="/assets/images/gb2.jpg" alt="Kandang pemeliharaan sapi perah">
                    <span class="tile-label">Kandang</span>
                </div>

                <div class="photo-tile tile-br">
                    <img src="/assets/images/gb4.jpg" alt="Pemberian hijauan pakan ternak">
                    <span class="tile-label">Hijauan</span>
                </div>

                <div class="device-card">
                    <div class="status-floating-badge">
                        <span class="badge-check-circle" aria-hidden="true">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        </span>
                        <div>
                            <div class="badge-main-text">Sistem Terpadu</div>
                            <div class="badge-sub-text">BBPTUHPT Baturraden</div>
                        </div>
                    </div>

                    <div class="device-screen-green">
                        <div class="device-header">
                            <div>
                                <h2 class="device-title">Monitoring Ternak<br>Sapi Perah</h2>
                                <span class="device-subtitle">Produktivitas &amp; Reproduksi</span>
                            </div>
                            <span class="dots-btn" aria-hidden="true">•••</span>
                        </div>

                        <svg class="wave-svg" viewBox="0 0 240 48" fill="none" aria-hidden="true">
                            <g stroke-width="2.6" stroke-linecap="round">
                                <line x1="10" y1="20" x2="10" y2="28" stroke="#4ade80" opacity="0.7" />
                                <line x1="20" y1="15" x2="20" y2="33" stroke="#4ade80" opacity="0.85" />
                                <line x1="30" y1="18" x2="30" y2="30" stroke="#86efac" opacity="0.7" />
                                <line x1="40" y1="10" x2="40" y2="38" stroke="#4ade80" />
                                <line x1="50" y1="16" x2="50" y2="32" stroke="#a3e635" />
                                <line x1="60" y1="8" x2="60" y2="40" stroke="#4ade80" />
                                <line x1="70" y1="14" x2="70" y2="34" stroke="#86efac" />
                                <line x1="80" y1="7" x2="80" y2="41" stroke="#a3e635" />
                                <line x1="90" y1="15" x2="90" y2="33" stroke="#4ade80" />
                                <line x1="100" y1="11" x2="100" y2="37" stroke="#84cc16" />
                                <line x1="110" y1="17" x2="110" y2="31" stroke="#4ade80" />
                                <line x1="120" y1="9" x2="120" y2="39" stroke="#a3e635" />
                                <line x1="130" y1="14" x2="130" y2="34" stroke="#4ade80" />
                                <line x1="140" y1="19" x2="140" y2="29" stroke="#86efac" />
                                <line x1="150" y1="10" x2="150" y2="38" stroke="#4ade80" />
                                <line x1="160" y1="15" x2="160" y2="33" stroke="#a3e635" />
                                <line x1="170" y1="7" x2="170" y2="41" stroke="#facc15" stroke-width="3.2" />
                                <line x1="180" y1="16" x2="180" y2="32" stroke="#84cc16" />
                                <line x1="190" y1="13" x2="190" y2="35" stroke="#4ade80" />
                                <line x1="200" y1="19" x2="200" y2="29" stroke="#a3e635" opacity="0.85" />
                                <line x1="210" y1="17" x2="210" y2="31" stroke="#4ade80" opacity="0.75" />
                                <line x1="220" y1="20" x2="220" y2="28" stroke="#86efac" opacity="0.65" />
                                <line x1="230" y1="21" x2="230" y2="27" stroke="#4ade80" opacity="0.55" />
                            </g>
                            <circle cx="170" cy="6" r="3" fill="#facc15" />
                        </svg>

                        <div class="wave-ticks">
                            <span>Laktasi 1</span>
                            <span>305 Hari</span>
                            <span>Sertifikat</span>
                        </div>
                    </div>

                    <div class="device-meta-row">
                        <span class="meta-left">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2">
                                <rect x="3" y="4" width="18" height="16" rx="3" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            Data Aktif
                        </span>
                        <a href="/landingpage/analisa" class="meta-right">e-Analisa →</a>
                    </div>

                    <div class="insight-card">
                        <div class="insight-pills">
                            <span class="pill-green">Bibit Unggul</span>
                            <span class="pill-gold">SC / DO</span>
                        </div>
                        <p class="insight-summary">
                            Rekap performa produksi susu, laktasi, dan reproduksi ternak siap dievaluasi secara akurat.
                        </p>
                        <div class="module-list">
                            <div class="module-item">
                                <span class="module-icon" aria-hidden="true">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 3h6v3l2 3v11a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V9l2-3V3z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="module-title">Produksi &amp; Laktasi</p>
                                    <p class="module-desc">Performa produksi susu, koreksi umur, dan JHP terstruktur.</p>
                                </div>
                            </div>
                            <div class="module-item">
                                <span class="module-icon" aria-hidden="true">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <path d="m9 15 2 2 4-4" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="module-title">Sertifikat Bibit Ternak</p>
                                    <p class="module-desc">Riwayat reproduksi, kesehatan, dan status sertifikasi bibit.</p>
                                </div>
                            </div>
                        </div>

                        <a href="/login" class="device-fab" title="Masuk e-Breeding" aria-label="Masuk e-Breeding">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bottom-bar">
            <div class="bottom-top">
                <span>Coba kalkulator produktivitas laktasi tanpa login melalui</span>
                <a href="/landingpage/analisa" class="bottom-link">e-Analisa Sapi Perah →</a>
            </div>
            <div class="feature-strip">
                <div class="feature-pill">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 3h6v3l2 3v11a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V9l2-3V3z" />
                    </svg>
                    <span>Produksi Susu</span>
                </div>
                <div class="feature-pill">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="14" r="4" />
                        <path d="M12 11l5-5m0 0h-4m4 0v4" />
                        <circle cx="16" cy="16" r="3" />
                    </svg>
                    <span>Reproduksi &amp; IB</span>
                </div>
                <div class="feature-pill">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    <span>Calving Interval</span>
                </div>
                <div class="feature-pill">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        <path d="M9 12h6M12 9v6" />
                    </svg>
                    <span>Kesehatan Ternak</span>
                </div>
                <div class="feature-pill">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="9" r="6" />
                        <path d="m8.5 14-1.5 8 5-2.5 5 2.5-1.5-8" />
                    </svg>
                    <span>Sertifikat Bibit</span>
                </div>
            </div>
        </footer>
    </div>

    <!-- Modal Fitur -->
    <div class="modal-backdrop" id="modal-fitur" role="dialog" aria-modal="true" aria-labelledby="modal-fitur-title">
        <div class="modal-card">
            <button type="button" class="modal-close" data-modal-close aria-label="Tutup">&times;</button>
            <div class="modal-eyebrow">Kemampuan Utama</div>
            <h2 class="modal-title" id="modal-fitur-title">Fitur &amp; Analisa e-Breeding</h2>
            <div class="modal-body">
                <p>e-Breeding menghasilkan informasi performa sapi perah, laporan produksi, reproduksi, kesehatan ternak, serta penerbitan sertifikat bibit ternak secara terstruktur.</p>
                <div class="modal-grid">
                    <div class="modal-chip">
                        <strong>Calving Interval (CI)</strong>
                        <span>Pemantauan jarak antar kelahiran indukan secara akurat.</span>
                    </div>
                    <div class="modal-chip">
                        <strong>Service Per Conception (SC)</strong>
                        <span>Evaluasi efisiensi inseminasi buatan hingga kebuntingan.</span>
                    </div>
                    <div class="modal-chip">
                        <strong>Days Open (DO) &amp; IB Post Partus</strong>
                        <span>Kontrol masa kosong dan kesiapan kawin pasca melahirkan.</span>
                    </div>
                    <div class="modal-chip">
                        <strong>Produksi &amp; Sertifikasi Bibit</strong>
                        <span>Koreksi produksi laktasi serta penerbitan sertifikat bibit resmi.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tentang -->
    <div class="modal-backdrop" id="modal-tentang" role="dialog" aria-modal="true" aria-labelledby="modal-tentang-title">
        <div class="modal-card">
            <button type="button" class="modal-close" data-modal-close aria-label="Tutup">&times;</button>
            <div class="modal-eyebrow">Tentang Aplikasi</div>
            <h2 class="modal-title" id="modal-tentang-title">e-Breeding BBPTUHPT Baturraden</h2>
            <div class="modal-body">
                <p>e-Breeding merupakan aplikasi yang dipergunakan untuk mengelola data sapi perah sedemikian rupa sehingga data berkaitan dengan produktivitas ternak dapat dikelola dengan baik, dikelompokkan berdasar kriteria tertentu yang ditetapkan, dan dilakukan perhitungan tertentu.</p>
                <p>Sertifikat bibit ternak dapat dikeluarkan menggunakan aplikasi ini, dan sistem dapat diakses melalui jaringan internet menggunakan PC, laptop, maupun smartphone.</p>
                <div class="modal-profile">
                    <img src="/assets/images/bbptusp.png" alt="Logo BBPTUHPT Baturraden">
                    <div>
                        <strong style="color:#0b3b20; display:block; margin-bottom:2px;">BBPTUHPT Baturraden</strong>
                        <span>Balai Besar Pembibitan Ternak Unggul dan Hijauan Pakan Ternak Baturraden &bull; &copy; <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var openers = document.querySelectorAll('[data-modal-open]');
            var modals = document.querySelectorAll('.modal-backdrop');
            var menuToggle = document.getElementById('menuToggle');
            var mainNav = document.getElementById('mainNav');

            function closeMenu() {
                if (!menuToggle || !mainNav) return;
                mainNav.classList.remove('open');
                menuToggle.classList.remove('is-open');
                menuToggle.setAttribute('aria-expanded', 'false');
            }

            if (menuToggle && mainNav) {
                menuToggle.addEventListener('click', function () {
                    var willOpen = !mainNav.classList.contains('open');
                    mainNav.classList.toggle('open', willOpen);
                    menuToggle.classList.toggle('is-open', willOpen);
                    menuToggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
                });
            }

            function closeAll() {
                modals.forEach(function (m) { m.classList.remove('open'); });
            }

            openers.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    closeMenu();
                    closeAll();
                    var target = document.getElementById('modal-' + btn.getAttribute('data-modal-open'));
                    if (target) target.classList.add('open');
                });
            });

            modals.forEach(function (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal || e.target.hasAttribute('data-modal-close')) {
                        closeAll();
                    }
                });
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeAll();
                    closeMenu();
                }
            });
        })();
    </script>
</body>

</html>
