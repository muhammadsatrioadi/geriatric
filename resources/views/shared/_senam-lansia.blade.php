@php
if (!isset($videoSrc)) {
    $videoSrc = asset('videos/senam-lansia-final.mp4');
}
@endphp
<div class="senam-lansia-wrapper mb-4">
    <h6 class="mb-3 fw-bold">
        <i class="fas fa-play-circle text-primary"></i>
        Video Rekomendasi Latihan Senam Lansia
    </h6>
    <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm border">
        <video controls preload="metadata" playsinline class="w-100 h-100" style="object-fit: contain; background:#000;"
               onerror="this.nextElementSibling.style.display='block'; this.style.display='none';">
            <source src="{{ $videoSrc }}?v={{ time() }}" type="video/mp4">
        </video>
        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-dark text-white p-4" style="display:none;">
            <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
            <p class="mb-2 text-center"><b>Video tidak dapat diputar otomatis.</b></p>
            <p class="small text-muted mb-3 text-center">Pastikan file <code>senam-lansia-final.mp4</code> sudah ter-upload di folder <code>public/videos/</code> server.</p>
            <a href="{{ $videoSrc }}" target="_blank" class="btn btn-primary btn-sm">
                <i class="fas fa-download me-1"></i> Klik di sini untuk buka / unduh video
            </a>
        </div>
    </div>
    <p class="text-muted small mt-2 mb-0">
        <i class="fas fa-info-circle"></i>
        Lakukan latihan senam lansia di atas secara rutin minimal <b>3 kali seminggu</b> sesuai petunjuk medis, dengan pendampingan keluarga/perawat agar aman.
    </p>
</div>
