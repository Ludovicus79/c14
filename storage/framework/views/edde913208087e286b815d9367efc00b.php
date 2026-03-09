<?php $__env->startSection('estilos'); ?>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Source+Sans+3:wght@300;400;600;700&family=Roboto+Mono:wght@500&display=swap" rel="stylesheet">
<style>
    :root {
        --wine:      #9b1b1b;
        --dark-wine: #9d1111;
        --red-light: #c0392b;
        --cream:     #faf8f4;
        --sand:      #f2ede4;
        --stone:     #e8e0d5;
        --ink:       #1a1410;
        --muted:     #5a5248;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { margin: 0 !important; padding: 0 !important; }
    .wrapper { min-height: unset !important; padding: 0 !important; margin: 0 !important; }

    /* ── OCULTAR TODO LO QUE VIENE DEL MASTER ── */
    header.container-fluid,
    #barraSup,
    .navbar.navbar-default,
    nav.navbar,
    header { display: none !important; height: 0 !important; overflow: hidden !important; }

    html { font-size: 18px; }
    @media (max-width: 1200px) { html { font-size: 16px; } }
    @media (max-width: 768px)  { html { font-size: 15px; } }

    /* ══════════════════════════════════════
       BARRA SUPERIOR — NAVEGACIÓN INLINE
    ══════════════════════════════════════ */
    .top-nav {
        background: var(--dark-wine);
        position: sticky;
        top: 0;
        width: 100%;
        z-index: 997;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .top-nav-inner {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 64px;
        padding: 0 24px 0 32px;
        gap: 16px;
    }

    .top-nav-brand {
        display: flex;
        align-items: center;
        flex-shrink: 0;
        text-decoration: none;
        padding: 0;
        margin: 0;
    }

    /* Links de navegación */
    .top-nav-links {
        display: flex;
        align-items: center;
        gap: 4px;
        flex: 1;
        justify-content: center;
        flex-wrap: nowrap;
        overflow: hidden;
    }

    .top-nav-link {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        color: rgba(255,255,255,0.9) !important;
        text-decoration: none !important;
        border-radius: 3px;
        transition: all 0.18s ease;
        white-space: nowrap;
    }
    .top-nav-link:hover,
    .top-nav-link.active {
        background: rgba(255,255,255,0.12);
        color: #fff !important;
    }
    .top-nav-link.active {
        background: rgba(255,255,255,0.18);
    }

    /* Separadores entre links */
    .top-nav-sep {
        width: 1px;
        height: 16px;
        background: rgba(255,255,255,0.18);
        flex-shrink: 0;
    }

    /* Botón idioma derecha */
    .lang-toggle-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.22);
        color: #fff;
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        border-radius: 3px;
        transition: background 0.18s;
        flex-shrink: 0;
        white-space: nowrap;
    }
    .lang-toggle-btn:hover { background: rgba(255,255,255,0.2); }
    .lang-toggle-btn .lang-flag { font-size: 1.1rem; }
    .lang-toggle-btn .chevron {
        font-size: 0.85rem;
        opacity: 0.7;
        transition: transform 0.2s;
    }
    .lang-toggle-btn.open .chevron { transform: rotate(180deg); }

    /* ══════════════════════════════════════
       AUTH BAR — barra superior login
    ══════════════════════════════════════ */
    .auth-bar {
        background: #831212;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        padding: 5px 32px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        font-family: 'Source Sans 3', sans-serif;
        font-size: 0.82rem;
    }
    .auth-bar-user {
        color: rgba(255,255,255,0.65);
        font-size: 0.82rem;
    }
    .auth-bar-user strong {
        color: rgba(255,255,255,0.9);
    }
    .auth-bar-link {
        display: inline-flex;
        align-items: center;
        padding: 3px 14px;
        border-radius: 2px;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        text-decoration: none !important;
        transition: all 0.15s;
        white-space: nowrap;
    }
    .auth-bar-link.login {
        color: rgba(255,255,255,0.85) !important;
        border: 1px solid rgba(255,255,255,0.25);
    }
    .auth-bar-link.login:hover {
        background: rgba(255,255,255,0.12);
        color: #fff !important;
    }
    .auth-bar-link.register {
        background: var(--wine);
        color: #fff !important;
        border: 1px solid transparent;
    }
    .auth-bar-link.register:hover {
        background: var(--red-light);
    }
    .auth-bar-link.logout {
        color: rgba(255,255,255,0.6) !important;
        border: 1px solid rgba(255,255,255,0.15);
    }
    .auth-bar-link.logout:hover {
        background: rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.9) !important;
    }
    .auth-bar-sep {
        width: 1px;
        height: 12px;
        background: rgba(255,255,255,0.15);
    }

    /* ══════════════════════════════════════
       RSS PUBLICACIONES
    ══════════════════════════════════════ */
    .rss-loading {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--muted);
        font-size: 0.9rem;
        padding: 12px 0;
    }
    .rss-spinner {
        width: 16px; height: 16px;
        border: 2px solid var(--stone);
        border-top-color: var(--wine);
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
        flex-shrink: 0;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .rss-error {
        color: var(--muted);
        font-size: 0.85rem;
        padding: 8px 0;
        font-style: italic;
    }
    .rss-source {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.72rem;
        font-family: 'Roboto Mono', monospace;
        color: var(--muted);
        margin-bottom: 14px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .rss-dot {
        width: 7px; height: 7px;
        background: #f60;
        border-radius: 50%;
        animation: pulse-rss 1.8s ease-in-out infinite;
    }
    @keyframes pulse-rss {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.4; transform: scale(0.7); }
    }

    /* ══════════════════════════════════════
       PANEL LATERAL DE IDIOMAS
    ══════════════════════════════════════ */
    .lang-panel-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 1500;
        background: rgba(26,20,16,0.35);
    }
    .lang-panel-overlay.open { display: block; }

    .lang-panel {
        position: fixed;
        top: 0;
        right: -320px;
        width: 300px;
        height: 100vh;
        background: #fff;
        z-index: 1501;
        box-shadow: -8px 0 40px rgba(0,0,0,0.18);
        display: flex;
        flex-direction: column;
        transition: right 0.32s cubic-bezier(0.4,0,0.2,1);
    }
    .lang-panel.open { right: 0; }

    .lang-panel-header {
        background: var(--dark-wine);
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }
    .lang-panel-header h3 {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #fff;
    }
    .lang-panel-close {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.25);
        color: #fff;
        width: 32px;
        height: 32px;
        border-radius: 3px;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s;
    }
    .lang-panel-close:hover { background: rgba(255,255,255,0.25); }

    .lang-panel-body {
        flex: 1;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        overflow-y: auto;
    }

    .lang-option {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 18px;
        border: 2px solid var(--stone);
        cursor: pointer;
        transition: all 0.18s;
        text-decoration: none;
        color: var(--ink);
        background: #fff;
    }
    .lang-option:hover { border-color: var(--wine); background: var(--cream); }
    .lang-option.active {
        border-color: var(--wine);
        background: var(--cream);
    }
    .lang-option.active::after {
        content: '✓';
        margin-left: auto;
        color: var(--wine);
        font-weight: 700;
        font-size: 1rem;
    }

    .lang-flag-big { width: 32px; height: 22px; object-fit: cover; border-radius: 3px; flex-shrink: 0; }

    .lang-option-info { display: flex; flex-direction: column; gap: 2px; }
    .lang-option-name {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--ink);
    }
    .lang-option-native {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1.1rem;
        color: var(--muted);
    }

    /* ══════════════════════════════════════
       HERO
    ══════════════════════════════════════ */
    .hero {
        position: relative;
        width: 100%;
        min-height: 78vh;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        overflow: hidden;
        background: var(--ink);
    }
    .hero-bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center 30%;
        opacity: 1;
    }
    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(26,20,16,0.10) 0%,
            rgba(26,20,16,0.28) 40%,
            rgba(26,20,16,0.82) 78%,
            rgba(26,20,16,0.97) 100%
        );
    }
    .hero-accent {
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 5px;
        background: linear-gradient(to bottom, var(--wine), var(--red-light));
    }
    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
        padding: 0 80px 76px 80px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .hero-label {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-family: 'Roboto Mono', monospace;
        font-size: 1.1rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.65);
    }
    .hero-label::before {
        content: '';
        display: block;
        width: 30px;
        height: 2px;
        background: var(--red-light);
    }
    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(3.2rem, 5.5vw, 5.5rem);
        font-weight: 700;
        color: #fff;
        line-height: 1.1;
        max-width: 820px;
    }
    .hero-title sup {
        font-size: 0.45em;
        vertical-align: super;
        font-weight: 400;
    }
    .hero-label-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .hero-usal-shield {
        height: 42px;
        width: auto;
        filter: brightness(0) invert(1);
        opacity: 0.85;
    }
    .hero-subtitle {
        font-family: 'Source Sans 3', sans-serif;
        font-size: clamp(1.4rem, 2.2vw, 1.8rem);
        color: rgba(255,255,255,0.72);
        font-weight: 300;
        max-width: 620px;
        line-height: 1.65;
    }
    .hero-cta {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        margin-top: 8px;
        padding: 17px 38px;
        background: var(--wine);
        color: #fff;
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-decoration: none;
        border: 2px solid var(--wine);
        transition: all 0.25s ease;
        width: fit-content;
    }
    .hero-cta:hover { background: transparent; color: #fff; border-color: #fff; }
    .hero-cta::after { content: '→'; transition: transform 0.2s; }
    .hero-cta:hover::after { transform: translateX(5px); }

    .hero-stats {
        position: absolute;
        top: 36px;
        right: 56px;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 12px;
        align-items: flex-end;
    }
    .hero-stat {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.18);
        backdrop-filter: blur(12px);
        padding: 12px 22px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 120px;
    }
    .hero-stat strong {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: #fff;
        line-height: 1;
    }
    .hero-stat span {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 0.95rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.55);
        margin-top: 4px;
        white-space: nowrap;
    }

    /* ══════════════════════════════════════
       SECCIÓN BÚSQUEDAS
    ══════════════════════════════════════ */
    .search-section {
        background: var(--cream);
        padding: 88px 56px;
        border-bottom: 1px solid var(--stone);
    }
    .section-header {
        max-width: 1200px;
        margin: 0 auto 56px auto;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
    }
    .section-eyebrow {
        font-family: 'Roboto Mono', monospace;
        font-size: 1rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--wine);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-eyebrow::before {
        content: '';
        display: block;
        width: 22px;
        height: 2px;
        background: var(--wine);
    }
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.8rem, 4vw, 3.8rem);
        font-weight: 700;
        color: var(--ink);
        line-height: 1.15;
    }
    .section-link {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--wine);
        text-decoration: none;
        letter-spacing: 0.5px;
        white-space: nowrap;
        border-bottom: 1px solid transparent;
        transition: border-color 0.2s;
    }
    .section-link:hover { border-color: var(--wine); }

    .cards-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1px;
        background: var(--stone);
        border: 1px solid var(--stone);
    }
    .search-card {
        background: #fff;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        transition: background 0.2s;
        overflow: hidden;
    }
    .search-card:hover { background: var(--cream); }
    .search-card:hover .card-img img { transform: scale(1.04); }

    .card-img {
        width: 100%;
        height: 200px;
        overflow: hidden;
        background: #111;
    }
    .card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }
    .card-body {
        padding: 28px 24px 32px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
        border-top: 3px solid transparent;
        transition: border-color 0.2s;
    }
    .search-card:hover .card-body { border-color: var(--wine); }

    .card-num {
        font-family: 'Roboto Mono', monospace;
        font-size: 1rem;
        letter-spacing: 2px;
        color: var(--wine);
        opacity: 0.7;
    }
    .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 600;
        color: var(--ink);
        line-height: 1.25;
    }
    .card-desc {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1.2rem;
    }
    .card-arrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: auto;
        padding-top: 14px;
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--wine);
    }

    /* ══════════════════════════════════════
       PUBLICACIONES + INFO
    ══════════════════════════════════════ */
    .lower-section {
        background: var(--sand);
        padding: 88px 56px;
        border-bottom: 1px solid var(--stone);
    }
    .lower-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 72px;
        align-items: start;
    }

    .pub-list { display: flex; flex-direction: column; gap: 0; }
    .pub-item {
        display: flex;
        flex-direction: column;
        padding: 26px 0 26px 20px;
        border-bottom: 1px solid var(--stone);
        cursor: pointer;
        transition: background 0.15s;
        position: relative;
    }
    .pub-item::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--stone);
        transition: background 0.2s;
    }
    .pub-item:hover::before { background: var(--wine); }
    .pub-item:first-child { padding-top: 0; }

    .pub-year {
        font-family: 'Roboto Mono', monospace;
        font-size: 1rem;
        letter-spacing: 2px;
        color: var(--wine);
        margin-bottom: 8px;
    }
    .pub-title {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1.35rem;
        font-weight: 600;
        color: var(--ink);
        line-height: 1.5;
        transition: color 0.2s;
    }
    .pub-item:hover .pub-title { color: var(--wine); }

    .pub-scholar {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 32px;
        padding: 16px 28px;
        background: #1a73e8;
        color: #fff;
        text-decoration: none;
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        transition: background 0.2s;
        width: fit-content;
    }
    .pub-scholar:hover { background: #1557b0; }
    .pub-scholar::after { content: '→'; }

    .info-panel { display: flex; flex-direction: column; gap: 28px; position: sticky; top: 70px; }
    .info-box { background: #fff; border: 1px solid var(--stone); padding: 30px 28px; }
    .info-box-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 16px;
        padding-bottom: 14px;
        border-bottom: 2px solid var(--wine);
    }
    .stat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 18px 10px;
        background: var(--cream);
    }
    .stat-num {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 700;
        color: var(--wine);
        line-height: 1;
    }
    .stat-label {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 0.75rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--muted);
        margin-top: 5px;
    }
    .dept-info {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1.25rem;
    }
    .dept-info strong { color: var(--ink); font-weight: 700; }
    .dept-info a { color: var(--wine); text-decoration: none; border-bottom: 1px solid transparent; transition: border-color 0.2s; }
    .dept-info a:hover { border-color: var(--wine); }

    /* ══════════════════════════════════════
       MODAL PREVIEW
    ══════════════════════════════════════ */
    .preview-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(26,20,16,0.7);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }
    .preview-modal.open { display: flex; }
    .preview-modal-box {
        background: #fff;
        width: 100%;
        max-width: 920px;
        height: 84vh;
        max-height: 740px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 40px 100px rgba(0,0,0,0.4);
        animation: modalIn 0.22s ease;
    }
    @keyframes modalIn {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .preview-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 22px;
        background: var(--dark-wine);
        flex-shrink: 0;
    }
    .preview-modal-title {
        color: #fff;
        font-family: 'Source Sans 3', sans-serif;
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.3;
        flex: 1;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .preview-modal-actions { display: flex; gap: 8px; flex-shrink: 0; }
    .preview-open-btn {
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.35);
        padding: 7px 16px;
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
    }
    .preview-open-btn:hover { background: rgba(255,255,255,0.28); }
    .preview-close-btn {
        background: rgba(255,255,255,0.12);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.3);
        width: 36px; height: 36px;
        font-size: 1.1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }
    .preview-close-btn:hover { background: rgba(255,255,255,0.25); }
    .preview-modal-body { flex: 1; position: relative; overflow: hidden; }
    .preview-modal-body iframe { width: 100%; height: 100%; border: none; display: block; }
    .preview-blocked {
        display: none;
        position: absolute;
        inset: 0;
        background: var(--cream);
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 20px;
        text-align: center;
        padding: 40px;
    }
    .preview-blocked p { font-family: 'Source Sans 3', sans-serif; font-size: 1.1rem; color: var(--muted); }
    .preview-fallback-btn {
        background: var(--wine);
        color: #fff;
        padding: 14px 30px;
        text-decoration: none;
        font-family: 'Source Sans 3', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        transition: background 0.2s;
    }
    .preview-fallback-btn:hover { background: var(--dark-wine); }

    /* ══════════════════════════════════════
       RESPONSIVE
    ══════════════════════════════════════ */
    @media (max-width: 1100px) {
        .lower-grid { grid-template-columns: 1fr; gap: 52px; }
        .info-panel { position: static; }
        .stat-grid { grid-template-columns: repeat(4, 1fr); }
    }

    @media (max-width: 960px) {
        .top-nav-links { display: none; }
        .hero-stats { display: none; }
        .cards-grid { grid-template-columns: repeat(2, 1fr); }
        .hero-content, .search-section, .lower-section { padding-left: 32px; padding-right: 32px; }
    }

    @media (max-width: 640px) {
        .top-nav-inner { padding: 0 16px; }
        .top-nav-brand { display: none; }
        .hero { min-height: 62vh; }
        .hero-content { padding: 0 18px 40px; gap: 14px; }
        .hero-title { font-size: 2.2rem; }
        .hero-cta { padding: 14px 26px; font-size: 0.95rem; }
        .search-section, .lower-section { padding: 48px 18px; }
        .section-header { flex-direction: column; align-items: flex-start; }
        .cards-grid { grid-template-columns: 1fr 1fr; }
        .card-img { height: 140px; }
        .card-body { padding: 18px 16px 22px; }
        .stat-grid { grid-template-columns: 1fr 1fr; }
        .preview-modal-box { height: 90vh; }
        .lang-panel { width: 100%; right: -100%; }
        .lang-panel.open { right: 0; }
    }

    @media (max-width: 420px) {
        .cards-grid { grid-template-columns: 1fr; }
        .hero-title { font-size: 1.85rem; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContainer'); ?>

<!-- ══ BARRA AUTH SUPERIOR ══ -->
<div class="auth-bar">
    <?php if(auth()->guard()->check()): ?>
        <span class="auth-bar-user"><?php echo e(trans('applicationResource.user.user')); ?>, <strong><?php echo e(Auth::user()->name); ?></strong></span>
        <div class="auth-bar-sep"></div>
        <?php if(Auth::user()->role === 'admin' || Auth::user()->isAdmin ?? false): ?>
            <a href="<?php echo e(url('admin')); ?>" class="auth-bar-link login"><?php echo e(trans('applicationResource.menu.admin')); ?></a>
            <div class="auth-bar-sep"></div>
        <?php endif; ?>
        <a href="<?php echo e(url('historial')); ?>" class="auth-bar-link login"><?php echo e(trans('applicationResource.menu.historial')); ?></a>
        <div class="auth-bar-sep"></div>
        <a href="<?php echo e(url('logout')); ?>" class="auth-bar-link logout"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <?php echo e(trans('applicationResource.menu.logout')); ?>

        </a>
        <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST" style="display:none;"><?php echo e(csrf_field()); ?></form>
    <?php else: ?>
        <a href="<?php echo e(url('login')); ?>" class="auth-bar-link login"><?php echo e(trans('applicationResource.menu.sesion')); ?></a>
        <div class="auth-bar-sep"></div>
        <a href="<?php echo e(url('register')); ?>" class="auth-bar-link register"><?php echo e(trans('applicationResource.menu.signUp')); ?></a>
    <?php endif; ?>
</div>

<!-- ══ BARRA NAVEGACIÓN SUPERIOR ══ -->
<nav class="top-nav">
    <div class="top-nav-inner">

        <!-- Logo izquierda -->
        <a href="<?php echo e(url('/')); ?>" class="top-nav-brand">
            <img src="<?php echo e(asset('images/naproclogo.png')); ?>" alt="NAPROC-13" style="height:64px; width:auto; max-width:14em; object-fit:contain; display:block;">
        </a>

        <!-- Secciones en línea -->
        <div class="top-nav-links">
            <a href="<?php echo e(url('search/byName')); ?>" class="top-nav-link" data-i18n-nav="nav_byname">Por Nombre</a>
            <div class="top-nav-sep"></div>
            <a href="<?php echo e(url('search/bySubstructure')); ?>" class="top-nav-link" data-i18n-nav="nav_sub">Subestructura</a>
            <div class="top-nav-sep"></div>
            <a href="<?php echo e(url('search/byShiftNoPosition')); ?>" class="top-nav-link" data-i18n-nav="nav_shift">Chemical Shift</a>
            <div class="top-nav-sep"></div>
            <a href="<?php echo e(url('search/byCarbonType')); ?>" class="top-nav-link" data-i18n-nav="nav_carbon">Tipo de Carbono</a>
            <div class="top-nav-sep"></div>
            <a href="<?php echo e(url('about')); ?>" class="top-nav-link" data-i18n-nav="nav_about">Acerca de</a>
        
        </div>

        <!-- Botón idioma -->
        <button class="lang-toggle-btn" id="langToggleBtn" onclick="openLangPanel()">
            <img class="lang-flag" id="currentFlagImg" src="https://flagcdn.com/w40/es.png" alt="ES" style="width:22px;height:15px;object-fit:cover;border-radius:2px;vertical-align:middle;">
            <span id="currentLangLabel">ES</span>
            <span class="chevron">▼</span>
        </button>

    </div>
</nav>

<!-- ══ PANEL LATERAL IDIOMAS ══ -->
<div class="lang-panel-overlay" id="langOverlay" onclick="closeLangPanel()"></div>
<div class="lang-panel" id="langPanel">
    <div class="lang-panel-header">
        <h3>Seleccionar idioma</h3>
        <button class="lang-panel-close" onclick="closeLangPanel()">✕</button>
    </div>
    <div class="lang-panel-body">
        <div class="lang-option active" id="lang-es" onclick="selectLang('es')">
            <img class="lang-flag-big" src="https://flagcdn.com/w40/es.png" alt="ES">
            <div class="lang-option-info">
                <span class="lang-option-name">Español</span>
                <span class="lang-option-native">Español</span>
            </div>
        </div>
        <div class="lang-option" id="lang-en" onclick="selectLang('en')">
            <img class="lang-flag-big" src="https://flagcdn.com/w40/gb.png" alt="EN">
            <div class="lang-option-info">
                <span class="lang-option-name">Inglés</span>
                <span class="lang-option-native">English</span>
            </div>
        </div>
        <div class="lang-option" id="lang-zh" onclick="selectLang('zh')">
            <img class="lang-flag-big" src="https://flagcdn.com/w40/cn.png" alt="ZH">
            <div class="lang-option-info">
                <span class="lang-option-name">Chino</span>
                <span class="lang-option-native">中文</span>
            </div>
        </div>
        <div class="lang-option" id="lang-it" onclick="selectLang('it')">
            <img class="lang-flag-big" src="https://flagcdn.com/w40/it.png" alt="IT">
            <div class="lang-option-info">
                <span class="lang-option-name">Italiano</span>
                <span class="lang-option-native">Italiano</span>
            </div>
        </div>
        <div class="lang-option" id="lang-de" onclick="selectLang('de')">
            <img class="lang-flag-big" src="https://flagcdn.com/w40/de.png" alt="DE">
            <div class="lang-option-info">
                <span class="lang-option-name">Alemán</span>
                <span class="lang-option-native">Deutsch</span>
            </div>
        </div>
        <div class="lang-option" id="lang-fr" onclick="selectLang('fr')">
            <img class="lang-flag-big" src="https://flagcdn.com/w40/fr.png" alt="FR">
            <div class="lang-option-info">
                <span class="lang-option-name">Francés</span>
                <span class="lang-option-native">Français</span>
            </div>
        </div>
        <div class="lang-option" id="lang-pt" onclick="selectLang('pt')">
            <img class="lang-flag-big" src="https://flagcdn.com/w40/pt.png" alt="PT">
            <div class="lang-option-info">
                <span class="lang-option-name">Portugués</span>
                <span class="lang-option-native">Português</span>
            </div>
        </div>
    </div>
</div>

<!-- ══ HERO ══ -->
<section class="hero">
    <img class="hero-bg" src="<?php echo e(asset('images/plumeria.jpg')); ?>" onerror="this.src='<?php echo e(asset('images/plumeria2.jpg')); ?>'" alt="Natural Products">
    <div class="hero-overlay"></div>
    <div class="hero-accent"></div>

    <div class="hero-stats">
        <div class="hero-stat">
            <strong>+30.000</strong>
            <span>Compuestos</span>
        </div>
        <div class="hero-stat">
            <strong>C¹³</strong>
            <span>NMR Data</span>
        </div>
        <div class="hero-stat">
            <strong>USAL</strong>
            <span>1218 d.C.</span>
        </div>
    </div>

    <div class="hero-content">
        <div class="hero-label-row">
            <img src="<?php echo e(asset('images/Logo_Usal_Hor_Eng_Blanco_2011.png')); ?>"
                 alt="Universidad de Salamanca"
                 style="height:88px; width:auto; opacity:0.90; filter:brightness(0) invert(1);">
            <span style="width:1px; height:22px; background:rgba(255,255,255,0.25); display:inline-block; margin:0 8px;"></span>
            <p class="hero-label">Dpto. Ciencias Farmacéuticas</p>
        </div>
        <h1 class="hero-title">
            Natural Products <br>C<sup>13</sup> NMR Database
        </h1>
        <p class="hero-subtitle" data-i18n="subtitle">
            Esta aplicación proporciona diferentes herramientas de búsqueda para determinar la estructura de un compuesto de productos naturales
        </p>
        <a href="<?php echo e(url('search/byName')); ?>" class="hero-cta" data-i18n="start_search">
            Iniciar búsqueda
        </a>
    </div>
</section>

<!-- ══ HERRAMIENTAS DE BÚSQUEDA ══ -->
<section class="search-section">
    <div class="section-header">
        <div>
            <p class="section-eyebrow" data-i18n-nav="nav_tools">Herramientas</p>
            <h2 class="section-title" data-i18n="search_heading">Búsqueda en la base de datos</h2>
        </div>
        <a href="<?php echo e(url('search/byName')); ?>" class="section-link" data-i18n="start_search">
            Ver todas las opciones →
        </a>
    </div>

    <div class="cards-grid">
        <a href="<?php echo e(url('search/byName')); ?>" class="search-card">
            <div class="card-img" style="background: #ffffff;">
                <img src="<?php echo e(asset('images/imagen1.png')); ?>" alt="By Name"
                     style="width:100%; height:100%; object-fit:contain; display:block; padding:16px;">
            </div>
            <div class="card-body">
                <span class="card-num">01</span>
                <h3 class="card-title" data-i18n="by_name">Por Nombre</h3>
                <p class="card-desc" data-i18n="by_name_desc">Busca compuestos por su nomenclatura química completa.</p>
                <span class="card-arrow">Buscar →</span>
            </div>
        </a>
        <a href="<?php echo e(url('search/bySubstructure')); ?>" class="search-card">
            <div class="card-img">
                <img src="<?php echo e(asset('images/imagen2.jpg')); ?>" alt="Substructure">
            </div>
            <div class="card-body">
                <span class="card-num">02</span>
                <h3 class="card-title" data-i18n="substructure">Subestructura</h3>
                <p class="card-desc" data-i18n="substructure_desc">Identifica moléculas analizando sus fragmentos estructurales.</p>
                <span class="card-arrow">Buscar →</span>
            </div>
        </a>
        <a href="<?php echo e(url('search/byShiftNoPosition')); ?>" class="search-card">
            <div class="card-img" style="background:#1a2a3a;">
                <img src="<?php echo e(asset('images/imagen3.png')); ?>" alt="Chemical Shift">
            </div>
            <div class="card-body">
                <span class="card-num">03</span>
                <h3 class="card-title" data-i18n="chemical_shift">Chemical Shift</h3>
                <p class="card-desc" data-i18n="chemical_shift_desc">Búsqueda basada en valores de desplazamientos de RMN ¹³C.</p>
                <span class="card-arrow">Buscar →</span>
            </div>
        </a>
        <a href="<?php echo e(url('search/byCarbonType')); ?>" class="search-card">
            <div class="card-img" style="background:#000;">
                <img src="<?php echo e(asset('images/imagen4.png')); ?>" alt="Carbon Type">
            </div>
            <div class="card-body">
                <span class="card-num">04</span>
                <h3 class="card-title" data-i18n="carbon_type">Tipo de Carbono</h3>
                <p class="card-desc" data-i18n="carbon_type_desc">Filtra por tipos de carbono: metilos, metilenos y cuaternarios.</p>
                <span class="card-arrow">Buscar →</span>
            </div>
        </a>
    </div>
</section>

<!-- ══ PUBLICACIONES + INFO ══ -->
<section class="lower-section">
    <div class="lower-grid">

        <div>
            <p class="section-eyebrow">Investigación</p>
            <h2 class="section-title" style="margin-bottom:20px;" data-i18n="recent_pubs">Publicaciones Recientes</h2>

            <div class="rss-source">
                <span class="rss-dot"></span>
                RSS en vivo &middot; PubMed
            </div>

            <div class="pub-list" id="rss-pub-list">
                <div class="rss-loading" id="rss-loading-indicator">
                    <div class="rss-spinner"></div>
                    <span>Cargando publicaciones&hellip;</span>
                </div>
            </div>

            <script>
            (function() {
                var container  = document.getElementById('rss-pub-list');
                var scholarUrl = 'https://scholar.google.es/citations?user=9mWuiVoAAAAJ&hl=es&sortby=pubdate';

                fetch('/rss-feed')
                    .then(function(r) {
                        if (!r.ok) throw new Error('HTTP ' + r.status);
                        return r.json();
                    })
                    .then(function(data) {
                        if (data.error || !data.items || data.items.length === 0) {
                            container.innerHTML =
                                '<p class="rss-error">No se pudieron cargar las publicaciones. ' +
                                '<a href="' + scholarUrl + '" target="_blank" style="color:var(--wine)">Ver en Google Scholar &rarr;</a></p>';
                            return;
                        }
                        var html = '';
                        data.items.forEach(function(item) {
                            var safeLink  = (item.link || '#').replace(/'/g, "\\'").replace(/"/g, '&quot;');
                            var safeTitle = (item.title || '')
                                .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                            html += '<div class="pub-item" onclick="window.open(\'' + safeLink + '\',\'_blank\')">';
                            if (item.year) html += '<span class="pub-year">' + item.year + '</span>';
                            html += '<span class="pub-title">' + safeTitle + '</span>';
                            html += '</div>';
                        });
                        container.innerHTML = html;
                    })
                    .catch(function() {
                        container.innerHTML =
                            '<p class="rss-error">No se pudo conectar. ' +
                            '<a href="' + scholarUrl + '" target="_blank" style="color:var(--wine)">Ver en Google Scholar &rarr;</a></p>';
                    });
            })();
            </script>

            <a href="https://scholar.google.es/citations?user=9mWuiVoAAAAJ&hl=es&sortby=pubdate"
               target="_blank" class="pub-scholar" data-i18n="view_profile">
                Ver perfil en Google Scholar
            </a>
        </div>

        <div class="info-panel">
            <div class="info-box">
                <div class="info-box-title">NAPROC-13</div>
                <div class="stat-grid">
                    <div class="stat-item">
                        <span class="stat-num">+30.000</span>
                        <span class="stat-label">Compuestos</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">C¹³</span>
                        <span class="stat-label">RMN Data</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">4</span>
                        <span class="stat-label">Búsquedas</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">+20</span>
                        <span class="stat-label">Años</span>
                    </div>
                </div>
            </div>
            <div class="info-box">
                <div class="info-box-title">Contacto</div>
                <div class="dept-info">
                    <strong>Dr. José Luis López Pérez</strong><br>
                    Dpto. Ciencias Farmacéuticas<br>
                    Universidad de Salamanca<br><br>
                    <a href="mailto:lopez@usal.es">lopez@usal.es</a>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- MODAL PREVIEW -->
<div id="previewModal" class="preview-modal" onclick="closePreviewOutside(event)">
    <div class="preview-modal-box">
        <div class="preview-modal-header">
            <span id="previewTitle" class="preview-modal-title"></span>
            <div class="preview-modal-actions">
                <a id="previewOpenLink" href="#" target="_blank" class="preview-open-btn">↗ Abrir</a>
                <button onclick="closePreview()" class="preview-close-btn">✕</button>
            </div>
        </div>
        <div class="preview-modal-body">
            <iframe id="previewIframe" src="" sandbox="allow-scripts allow-same-origin allow-forms" loading="lazy"></iframe>
            <div class="preview-blocked">
                <p>⚠️ Esta página no permite previsualización.</p>
                <a id="previewFallbackLink" href="#" target="_blank" class="preview-fallback-btn">Abrir en nueva pestaña →</a>
            </div>
        </div>
    </div>
</div>

<script>
    // ── TRADUCCIONES ──
    const translations = {
        es: {
            title: "Natural Products <sup>13</sup>C NMR Database",
            subtitle: "Esta aplicación proporciona diferentes herramientas de búsqueda para determinar la estructura de un compuesto",
            start_search: "Iniciar búsqueda",
            search_heading: "Búsqueda en la base de datos",
            by_name: "Por Nombre",
            by_name_desc: "Busca compuestos por su nomenclatura química completa.",
            substructure: "Subestructura",
            substructure_desc: "Identifica moléculas analizando sus fragmentos estructurales.",
            chemical_shift: "Chemical Shift",
            chemical_shift_desc: "Búsqueda basada en valores de desplazamientos de RMN ¹³C.",
            carbon_type: "Tipo de Carbono",
            carbon_type_desc: "Filtra por tipos de carbono: metilos, metilenos y cuaternarios.",
            recent_pubs: "Publicaciones Recientes",
            view_profile: "Ver perfil en Google Scholar"
        },
        en: {
            title: "Natural Products <span class='hero-title-nmr'><sup>13</sup>C NMR</span> Database",
            subtitle: "This application provides different search tools to find out the structure of a natural product compound",
            start_search: "Start search",
            search_heading: "Search the database",
            by_name: "By Name",
            by_name_desc: "Search compounds by their complete chemical nomenclature.",
            substructure: "Substructure",
            substructure_desc: "Identify molecules by analyzing their structural fragments.",
            chemical_shift: "Chemical Shift",
            chemical_shift_desc: "Search based on ¹³C NMR chemical shift values.",
            carbon_type: "Carbon Type",
            carbon_type_desc: "Filter by carbon types: methyls, methylenes and quaternaries.",
            recent_pubs: "Recent Publications",
            view_profile: "View profile on Google Scholar"
        },
        zh: {
            title: "天然产物<span class='hero-title-nmr'><sup>13</sup>C</span>核磁共振数据库",
            subtitle: "本应用程序提供不同的搜索工具，以确定天然化合物的结构",
            start_search: "开始搜索",
            search_heading: "数据库搜索",
            by_name: "按名称",
            by_name_desc: "通过完整的化学命名法搜索化合物。",
            substructure: "子结构",
            substructure_desc: "通过分析结构片段识别分子。",
            chemical_shift: "化学位移",
            chemical_shift_desc: "基于¹³C NMR化学位移值进行搜索。",
            carbon_type: "碳类型",
            carbon_type_desc: "按碳类型过滤：甲基、亚甲基和季碳。",
            recent_pubs: "近期发表",
            view_profile: "在Google Scholar上查看完整资料"
        },
        it: {
            title: "Natural Products <span class='hero-title-nmr'><sup>13</sup>C NMR</span> Database",
            subtitle: "Questa applicazione fornisce diversi strumenti di ricerca per determinare la struttura di un composto",
            start_search: "Inizia ricerca",
            search_heading: "Ricerca nel database",
            by_name: "Per Nome",
            by_name_desc: "Cerca composti per la loro nomenclatura chimica completa.",
            substructure: "Sottostruttura",
            substructure_desc: "Identifica molecole analizzando i loro frammenti strutturali.",
            chemical_shift: "Chemical Shift",
            chemical_shift_desc: "Ricerca basata sui valori di spostamento chimico RMN ¹³C.",
            carbon_type: "Tipo di Carbonio",
            carbon_type_desc: "Filtra per tipi di carbonio: metili, metileni e quaternari.",
            recent_pubs: "Pubblicazioni Recenti",
            view_profile: "Visualizza profilo su Google Scholar"
        },
        de: {
            title: "Natural Products <span class='hero-title-nmr'><sup>13</sup>C NMR</span> Database",
            subtitle: "Diese Anwendung bietet verschiedene Suchwerkzeuge zur Strukturbestimmung von Verbindungen",
            start_search: "Suche starten",
            search_heading: "Datenbank durchsuchen",
            by_name: "Nach Name",
            by_name_desc: "Suche Verbindungen nach ihrer vollständigen chemischen Nomenklatur.",
            substructure: "Substruktur",
            substructure_desc: "Identifiziere Moleküle durch Analyse ihrer strukturellen Fragmente.",
            chemical_shift: "Chemical Shift",
            chemical_shift_desc: "Suche basierend auf ¹³C NMR chemischen Verschiebungswerten.",
            carbon_type: "Kohlenstofftyp",
            carbon_type_desc: "Filtere nach Kohlenstofftypen: Methyl-, Methylen- und Quartärkohlenstoffe.",
            recent_pubs: "Neueste Veröffentlichungen",
            view_profile: "Profil auf Google Scholar ansehen"
        },
        fr: {
            title: "Natural Products <span class='hero-title-nmr'><sup>13</sup>C NMR</span> Database",
            subtitle: "Cette application fournit différents outils de recherche pour déterminer la structure d'un composé",
            start_search: "Commencer la recherche",
            search_heading: "Rechercher dans la base de données",
            by_name: "Par Nom",
            by_name_desc: "Recherchez des composés par leur nomenclature chimique complète.",
            substructure: "Sous-structure",
            substructure_desc: "Identifiez les molécules en analysant leurs fragments structuraux.",
            chemical_shift: "Chemical Shift",
            chemical_shift_desc: "Recherche basée sur les valeurs de déplacement chimique RMN ¹³C.",
            carbon_type: "Type de Carbone",
            carbon_type_desc: "Filtrez par types de carbone : méthyles, méthylènes et quaternaires.",
            recent_pubs: "Publications Récentes",
            view_profile: "Voir le profil sur Google Scholar"
        },
        pt: {
            title: "Natural Products <span class='hero-title-nmr'><sup>13</sup>C NMR</span> Database",
            subtitle: "Esta aplicação fornece diferentes ferramentas de pesquisa para determinar a estrutura de um composto",
            start_search: "Iniciar pesquisa",
            search_heading: "Pesquisar na base de dados",
            by_name: "Por Nome",
            by_name_desc: "Pesquise compostos pela sua nomenclatura química completa.",
            substructure: "Subestrutura",
            substructure_desc: "Identifique moléculas analisando seus fragmentos estruturais.",
            chemical_shift: "Chemical Shift",
            chemical_shift_desc: "Pesquisa baseada em valores de deslocamento químico de RMN ¹³C.",
            carbon_type: "Tipo de Carbono",
            carbon_type_desc: "Filtre por tipos de carbono: metilos, metilenos e quaternários.",
            recent_pubs: "Publicações Recentes",
            view_profile: "Ver perfil no Google Scholar"
        }
    };

    const navTranslations = {
        es: { nav_byname:"Por Nombre", nav_sub:"Subestructura", nav_shift:"Chemical Shift", nav_carbon:"Tipo de Carbono", nav_about:"Acerca de", nav_contact:"Contacto", nav_tools:"Herramientas" },
        en: { nav_byname:"By Name", nav_sub:"Substructure", nav_shift:"Chemical Shift", nav_carbon:"Carbon Type", nav_about:"About", nav_contact:"Contact", nav_tools:"Tools" },
        zh: { nav_byname:"按名称", nav_sub:"子结构", nav_shift:"化学位移", nav_carbon:"碳类型", nav_about:"关于", nav_contact:"联系", nav_tools:"工具" },
        it: { nav_byname:"Per Nome", nav_sub:"Sottostruttura", nav_shift:"Chemical Shift", nav_carbon:"Tipo di Carbonio", nav_about:"Informazioni", nav_contact:"Contatto", nav_tools:"Strumenti" },
        de: { nav_byname:"Nach Name", nav_sub:"Substruktur", nav_shift:"Chemical Shift", nav_carbon:"Kohlenstofftyp", nav_about:"Über", nav_contact:"Kontakt", nav_tools:"Werkzeuge" },
        fr: { nav_byname:"Par Nom", nav_sub:"Sous-structure", nav_shift:"Chemical Shift", nav_carbon:"Type de Carbone", nav_about:"À propos", nav_contact:"Contact", nav_tools:"Outils" },
        pt: { nav_byname:"Por Nome", nav_sub:"Subestrutura", nav_shift:"Chemical Shift", nav_carbon:"Tipo de Carbono", nav_about:"Sobre", nav_contact:"Contato", nav_tools:"Ferramentas" }
    };

    const langMeta = {
        es: { flag: 'es', label: 'ES' },
        en: { flag: 'gb', label: 'EN' },
        zh: { flag: 'cn', label: '中' },
        it: { flag: 'it', label: 'IT' },
        de: { flag: 'de', label: 'DE' },
        fr: { flag: 'fr', label: 'FR' },
        pt: { flag: 'pt', label: 'PT' }
    };

    let currentLang = localStorage.getItem('naproc-lang') || 'es';

    function changeLanguage(lang) {
        currentLang = lang;
        localStorage.setItem('naproc-lang', lang);
        // Textos principales
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (translations[lang] && translations[lang][key]) el.innerHTML = translations[lang][key];
        });
        // Textos de nav
        document.querySelectorAll('[data-i18n-nav]').forEach(el => {
            const key = el.getAttribute('data-i18n-nav');
            if (navTranslations[lang] && navTranslations[lang][key]) el.textContent = navTranslations[lang][key];
        });
        // Actualizar botón
        const flagImg = document.getElementById('currentFlagImg');
        if (flagImg) flagImg.src = 'https://flagcdn.com/w40/' + langMeta[lang].flag + '.png';
        document.getElementById('currentLangLabel').textContent = langMeta[lang].label;
        // Actualizar activo en panel
        document.querySelectorAll('.lang-option').forEach(o => o.classList.remove('active'));
        const active = document.getElementById('lang-' + lang);
        if (active) active.classList.add('active');
    }

    // ── PANEL DE IDIOMAS ──
    function openLangPanel() {
        document.getElementById('langPanel').classList.add('open');
        document.getElementById('langOverlay').classList.add('open');
        document.getElementById('langToggleBtn').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeLangPanel() {
        document.getElementById('langPanel').classList.remove('open');
        document.getElementById('langOverlay').classList.remove('open');
        document.getElementById('langToggleBtn').classList.remove('open');
        document.body.style.overflow = '';
    }
    function selectLang(lang) {
        changeLanguage(lang);
        closeLangPanel();
    }

    // Cerrar con Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { closeLangPanel(); closePreview(); }
    });

    // ── PREVIEW MODAL ──
    function openPreview(url, title) {
        const modal   = document.getElementById('previewModal');
        const iframe  = document.getElementById('previewIframe');
        const blocked = document.querySelector('.preview-blocked');
        document.getElementById('previewTitle').textContent = title;
        document.getElementById('previewOpenLink').href = url;
        document.getElementById('previewFallbackLink').href = url;
        iframe.style.display = 'block';
        blocked.style.display = 'none';
        iframe.src = '';
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
        iframe.onload = function() {
            try {
                const doc = iframe.contentDocument || iframe.contentWindow.document;
                if (!doc || doc.body.innerHTML === '') throw new Error('blocked');
            } catch(e) {
                iframe.style.display = 'none';
                blocked.style.display = 'flex';
            }
        };
        iframe.onerror = function() {
            iframe.style.display = 'none';
            blocked.style.display = 'flex';
        };
        setTimeout(() => { iframe.src = url; }, 50);
    }
    function closePreview() {
        document.getElementById('previewModal').classList.remove('open');
        document.getElementById('previewIframe').src = '';
        document.body.style.overflow = '';
    }
    function closePreviewOutside(e) {
        if (e.target === document.getElementById('previewModal')) closePreview();
    }

    // ── INIT ──
    document.addEventListener('DOMContentLoaded', () => {
        changeLanguage(currentLang);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/usuario/Downloads/C14-CORREGIDO/C14-main-2/resources/views/home.blade.php ENDPATH**/ ?>