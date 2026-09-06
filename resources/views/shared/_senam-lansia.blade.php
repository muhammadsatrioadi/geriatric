@php
$vCacheBuster = '20260906fix';
if (!isset($videoSrc)) {
    $videoSrc = asset('videos/senam-lansia-final.mp4');
}
$fallbackSrc1 = asset('videos/senam-lansia-final.mp4');
$fallbackSrc2 = asset('storage/videos/1788711376_SENAM NEW FINAL 1.mp4');
@endphp
<div class="senam-lansia-wrapper mb-4">
    <h6 class="mb-3 fw-bold">
        <i class="fas fa-play-circle text-primary"></i>
        Video Rekomendasi Latihan Senam Lansia
    </h6>
    <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm border">
        <video id="senamLansiaVideo" controls preload="metadata" playsinline
               class="w-100 h-100" style="object-fit: contain; background:#000;"
               data-src-1="{{ $fallbackSrc1 }}?v={{ $vCacheBuster }}"
               data-src-2="{{ $fallbackSrc2 }}&v={{ $vCacheBuster }}"
               onerror="window.handleSenamVideoError(this);">
            <source src="{{ $fallbackSrc1 }}?v={{ $vCacheBuster }}" type="video/mp4">
        </video>
        <div id="senamLansiaFallback"
             class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-dark text-white p-4"
             style="display:none;">
            <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
            <p class="mb-2 text-center"><b>Video tidak dapat diputar otomatis.</b></p>
            <p class="small text-muted mb-3 text-center">
                Coba salah satu link alternatif di bawah:
            </p>
            <div class="d-grid gap-2 col-10 col-md-8 mx-auto">
                <a href="{{ $fallbackSrc1 }}?v={{ $vCacheBuster }}" target="_blank" class="btn btn-primary btn-sm">
                    <i class="fas fa-download me-1"></i> Opsi 1: Buka video (public/videos)
                </a>
                <a href="{{ $fallbackSrc2 }}&v={{ $vCacheBuster }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-cloud-download-alt me-1"></i> Opsi 2: Buka video (storage Super Admin)
                </a>
            </div>
            <p class="small text-muted mt-3 mb-0 text-center">
                Ukuran file: ~65 MB • Durasi: ~9 menit 25 detik
            </p>
        </div>
    </div>
    <script>
    (function(){
        var triedCount = 0;
        window.handleSenamVideoError = function(videoEl){
            triedCount++;
            // Fallback 1 -> 2 -> terakhir tampilkan UI fallback
            if (triedCount === 1) {
                // Coba source ke-2 (storage Super Admin yang terbukti bisa)
                var src2 = videoEl.getAttribute('data-src-2');
                if (src2) {
                    videoEl.querySelector('source').src = src2;
                    videoEl.load();
                    return;
                }
            }
            // Fallback gagal total — tampilkan tombol unduh manual
            videoEl.style.display = 'none';
            var fb = document.getElementById('senamLansiaFallback');
            if (fb) fb.style.display = 'flex';
        };
    })();
    </script>
    <p class="text-muted small mt-2 mb-0">
        <i class="fas fa-info-circle"></i>
        Lakukan latihan senam lansia di atas secara rutin minimal <b>3 kali seminggu</b> sesuai petunjuk medis, dengan pendampingan keluarga/perawat agar aman.
    </p>
</div>
