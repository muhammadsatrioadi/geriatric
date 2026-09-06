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
        <video controls preload="metadata" playsinline class="w-100 h-100" style="object-fit: contain; background:#000;">
            <source src="{{ $videoSrc }}" type="video/mp4">
            <source src="{{ $videoSrc }}" type="video/quicktime">
            Browser Anda tidak mendukung pemutaran video.
            <a href="{{ $videoSrc }}" class="text-white d-block mt-2 text-center">
                <i class="fas fa-download"></i> Unduh video senam
            </a>
        </video>
    </div>
    <p class="text-muted small mt-2 mb-0">
        <i class="fas fa-info-circle"></i>
        Lakukan latihan senam lansia di atas secara rutin minimal <b>3 kali seminggu</b> sesuai petunjuk medis, dengan pendampingan keluarga/perawat agar aman.
    </p>
</div>
