@php
$vCacheBuster = '20260906v2';

// ✅ SUMBER UTAMA = storage Super Admin (TERBUKTI BISA PLAY! -> durasi 9:25 menit)
// Pakai url() + rawurlencode SPASI agar path konsisten, tidak campur encode tidak karuan
$storageBase = url('storage/videos/');
$videoFilename = '1788711376_SENAM NEW FINAL 1.mp4';
$mainVideoSrc = $storageBase . implode('/', array_map('rawurlencode', explode('/', $videoFilename))) . '?v=' . $vCacheBuster;

// Fallback = public/videos sebagai cadangan
$fallbackVideoSrc = asset('videos/senam-lansia-final.mp4') . '?v=' . $vCacheBuster;
@endphp
<div class="senam-lansia-wrapper mb-4">
    <h6 class="mb-3 fw-bold">
        <i class="fas fa-play-circle text-primary"></i>
        Video Rekomendasi Latihan Senam Lansia
    </h6>
    <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm border">
        <video id="senamLansiaVideoMain"
               controls
               playsinline
               preload="auto"
               class="w-100 h-100"
               style="object-fit: contain; background:#000;">
            {{-- ✅ SUMBER PERTAMA (YANG PASTI BISA): Storage Super Admin --}}
            <source src="{{ $mainVideoSrc }}" type="video/mp4">
            {{-- ✅ CADANGAN: public/videos --}}
            <source src="{{ $fallbackVideoSrc }}" type="video/mp4">
        </video>
        {{-- Fallback UI hanya jika KEDUA source BENAR-BENAR tidak bisa --}}
        <div id="senamLansiaFallbackUI"
             class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-dark text-white p-4"
             style="display:none;">
            <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
            <p class="mb-2 text-center"><b>Video tidak dapat dimuat otomatis.</b></p>
            <div class="d-grid gap-2 col-10 col-md-8 mx-auto">
                <a href="{{ $mainVideoSrc }}" target="_blank" class="btn btn-primary btn-sm">
                    <i class="fas fa-play-circle me-1"></i> Putar Video (Tab Baru)
                </a>
                <a href="{{ $fallbackVideoSrc }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-download me-1"></i> Download Video
                </a>
            </div>
            <p class="small text-muted mt-3 mb-0 text-center">
                Ukuran file: ~65 MB • Durasi: 9 menit 25 detik
            </p>
        </div>
    </div>

    <script>
    (function(){
        // === Video player yang SABAR — TIDAK ADA timer paksa hide.
        // Video player HANYA disembunyikan JIKA BENAR BENAR ERROR (404/corrupt),
        // BUKAN karena download metadata lambat (Cloudflare tunnel / internet lambat).
        // =====================================================
        var videoEl = document.getElementById('senamLansiaVideoMain');
        var fallbackEl = document.getElementById('senamLansiaFallbackUI');
        if (!videoEl || !fallbackEl) return;

        var isFallbackShown = false;
        var erroredOnce = false;

        function showFallback(){
            if (isFallbackShown) return;
            isFallbackShown = true;
            try {
                videoEl.style.setProperty('display', 'none', 'important');
            } catch(e) { videoEl.style.display = 'none'; }
            fallbackEl.style.display = 'flex';
        }
        function ensureVideoVisible(){
            // Kebalikan: pastikan player TETAP TERLIHAT jika ada metadata / play sukses
            if (isFallbackShown) return;
            fallbackEl.style.display = 'none';
            videoEl.style.display = '';
        }

        // ==================================================================
        // HANYA show fallback jika video BENAR BENAR ERROR (network 4xx/5xx / corrupt)
        // Coba terlebih dahulu switch ke source backup via JS, baru fallback.
        // ==================================================================
        videoEl.addEventListener('error', function onVidErr(){
            videoEl.removeEventListener('error', onVidErr);
            // Coba 1x lagi: paksa ganti src LANGSUNG ke storage Super Admin (TERBUKTI BISA) via JS
            if (!erroredOnce && videoEl.canPlayType('video/mp4')) {
                erroredOnce = true;
                videoEl.src = @json($mainVideoSrc);
                videoEl.load();
                var p = videoEl.play();
                if (p && typeof p.catch === 'function') { p.catch(function(){}); }
                // Beri waktu 15 detik untuk retry (Cloudflare tunnel lambat)
                setTimeout(function(){
                    // Jika setelah 15 detik readyState masih 0, BENAR BENAR gagal
                    if (videoEl.readyState === 0) showFallback();
                }, 15000);
                return;
            }
            showFallback();
        });

        // ==================================================================
        // Event BERHASIL — jika ini ke-fire, SEMUA OK. Pastikan fallback TIDAK muncul.
        // ==================================================================
        var successEvents = ['loadedmetadata','loadeddata','canplay','canplaythrough','play','playing','durationchange'];
        successEvents.forEach(function(evName){
            videoEl.addEventListener(evName, function(){
                if (isFallbackShown) return;
                ensureVideoVisible();
                // Jika autoplay muted, biarkan user klik unmute sendiri
            });
        });

        // ==================================================================
        // Auto play ATTEMPT (MUTED SAJA) — modern browser hanya izinkan autoplay MUTED
        // TETAPI: jika internet lambat, play() Promise pending lama — JANGAN ANGGAP ERROR.
        // Kita cuma "best effort", tidak masalah jika gagal, user tinggal klik play.
        // ==================================================================
        var tryAutoPlay = function(){
            try {
                videoEl.muted = true;
                var p = videoEl.play();
                if (p && typeof p.then === 'function') {
                    p.then(function(){
                        // autoplay muted berhasil — OK
                    }).catch(function(){
                        // autoplay di-block browser — NORMAL, user tinggal klik play.
                        // TIDAK usah unmute dulu, terserah user.
                    });
                }
            } catch(e) { /* autoplay attempt gagal — biasa saja */ }
        };

        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            setTimeout(tryAutoPlay, 300);
        } else {
            window.addEventListener('DOMContentLoaded', function(){ setTimeout(tryAutoPlay, 300); });
            window.addEventListener('load', function(){ setTimeout(tryAutoPlay, 300); });
        }

        // User KLIK area video — manual play, UNMUTE otomatis.
        videoEl.addEventListener('click', function(){
            try {
                videoEl.muted = false;
                if (videoEl.paused) { var p = videoEl.play(); if (p && typeof p.catch === 'function') p.catch(function(){}); }
            } catch(e) {}
        });
        // Beberapa browser iOS/Safari butuh unmute pada event playing
        videoEl.addEventListener('playing', function(){ try { videoEl.muted = false; } catch(e){} });
    })();
    </script>

    <p class="text-muted small mt-2 mb-0">
        <i class="fas fa-info-circle"></i>
        Lakukan latihan senam lansia di atas secara rutin minimal <b>3 kali seminggu</b> sesuai petunjuk medis, dengan pendampingan keluarga/perawat agar aman.
    </p>
</div>
