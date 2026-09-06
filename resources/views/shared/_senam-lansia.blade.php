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
        // === Auto play/load + deteksi KEGAGALAN total (tanpa race condition) ===
        var videoEl = document.getElementById('senamLansiaVideoMain');
        var fallbackEl = document.getElementById('senamLansiaFallbackUI');
        if (!videoEl || !fallbackEl) return;

        var isFallbackShown = false;
        var failTimer = null;

        // Setelah 10 DETIK sejak halaman load, jika:
        //   + readyState masih 0 / belum load, DAN
        //   + duration belum ketahui (NaN / Infinity / 0)
        // ==> BERARTI video BENAR-BENAR gagal. Tampilkan tombol manual.
        function videoSeemsStuck(){
            if (isFallbackShown) return false;
            var st = videoEl.readyState;   // 0 = HAVE_NOTHING (belum ada data sama sekali)
            var dr = videoEl.duration;
            // HAVE_NOTHING ATAU duration tidak masuk akal
            if (st === 0 || isNaN(dr) || dr === 0 || dr === Infinity || !isFinite(dr)) {
                return true;
            }
            return false;
        }

        function showFallback(){
            if (isFallbackShown) return;
            isFallbackShown = true;
            videoEl.style.display = 'none';
            fallbackEl.style.display = 'flex';
        }

        // Jika ada error -> coba mainkan source ke-2 secara manual, baru show fallback
        videoEl.addEventListener('error', function onVidErr(){
            // Coba paksa ganti source ke storage LANGSUNG via JS, reload, lalu coba play sekali
            videoEl.removeEventListener('error', onVidErr);
            if (videoEl.canPlayType('video/mp4')) {
                videoEl.src = @json($mainVideoSrc);
                videoEl.load();
                var tryPlay = videoEl.play();
                if (tryPlay && typeof tryPlay.catch === 'function') {
                    tryPlay.catch(function(){ /* autoplay di-block OK karena user masih bisa klik play */ });
                }
                // Jika 5 detik kemudian masih stuck, baru fallback
                failTimer = setTimeout(function(){ if (videoSeemsStuck()) showFallback(); }, 5000);
            } else {
                showFallback();
            }
        });

        // Event SUCCESS — jika user klik PLAY dan duration ketemu, SEMUA OK.
        videoEl.addEventListener('loadedmetadata', function(){
            if (isFallbackShown) return;
            // Video berhasil baca metadata -> fallback tidak perlu
            if (failTimer) { clearTimeout(failTimer); failTimer = null; }
        });
        videoEl.addEventListener('play', function(){
            if (failTimer) { clearTimeout(failTimer); failTimer = null; }
        });

        // Timer 8 detik pertama: cek metadata. Jika TIDAK PERNAH load samsek, fallback.
        failTimer = setTimeout(function(){
            if (videoSeemsStuck()) showFallback();
        }, 8000);

        // ⚠️ BUG FIX AUTOPLAY BLOCK: modern browser block video.autoplay SUARA ON.
        // Kita coba autoplay MUTED, jika user klik play -> unmute.
        var tryAutoPlay = function(){
            videoEl.muted = true;
            var p = videoEl.play();
            if (p && typeof p.then === 'function') {
                p.then(function(){
                    // Sukses autoplay MUTED — tampilkan badge "Klik untuk suarakan" via onplay
                }).catch(function(){
                    // Autoplay di-block browser -> Biasa saja, user tinggal klik play.
                    videoEl.muted = false;
                });
            }
        };
        // Jalankan ketika halaman sudah stabil (setelah 200ms)
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            setTimeout(tryAutoPlay, 200);
        } else {
            window.addEventListener('DOMContentLoaded', function(){ setTimeout(tryAutoPlay, 200); });
            window.addEventListener('load', function(){ setTimeout(tryAutoPlay, 200); });
        }

        // Ketika user KLIK play (manual), auto-unmute.
        videoEl.addEventListener('click', function(){
            if (videoEl.paused) { videoEl.play(); videoEl.muted = false; }
        });
        // WebKit iOS sometimes needs manual unmute after first interaction
        videoEl.addEventListener('playing', function(){ videoEl.muted = false; });
    })();
    </script>

    <p class="text-muted small mt-2 mb-0">
        <i class="fas fa-info-circle"></i>
        Lakukan latihan senam lansia di atas secara rutin minimal <b>3 kali seminggu</b> sesuai petunjuk medis, dengan pendampingan keluarga/perawat agar aman.
    </p>
</div>
