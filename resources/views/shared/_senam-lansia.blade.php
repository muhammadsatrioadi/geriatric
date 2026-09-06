@php
$vCacheBuster = 'v3_20260906_simple';

$storageBase = url('storage/videos/');
$videoFilename = '1788711376_SENAM NEW FINAL 1.mp4';
$mainVideoSrc = $storageBase
    . implode('/', array_map('rawurlencode', explode('/', $videoFilename)))
    . '?v=' . $vCacheBuster;

$fallbackVideoSrc = asset('videos/senam-lansia-final.mp4') . '?v=' . $vCacheBuster;

$videoType = 'video/mp4';
@endphp
<div class="senam-lansia-wrapper mb-4">
    <h6 class="mb-3 fw-bold">
        <i class="fas fa-play-circle text-primary"></i>
        Video Rekomendasi Latihan Senam Lansia
    </h6>

    <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm border">
        {{--
            =============================================================
            CARA PEMANGGILAN VIDEO = SAMA PERSIS DENGAN "PELATIHAN" di
            HALAMAN FORM INDEX SELF-ASSESSMENT (lihat index.blade.php baris 119 dst):
            - HANYA <video controls + preload="metadata" + playsinline>
            - TIDAK ADA timer auto-hide (tidak bikin video hilang karena lambat)
            - TIDAK ada autoplay rumit (bisa di-block browser)
            - TIDAK ada fallback UI paksa yang menyembunyikan player
            - User tinggal KLIK PLAY (seperti di panduan tes per-tes form)
            =============================================================
            Source PERTAMA = /storage/videos/1788711376... (TERBUKTI BISA di
            preview Super Admin dan Opsi 1 manual Anda). Source KEDUA =
            /videos/senam-lansia-final.mp4 sebagai cadangan.
        --}}
        <video controls class="w-100 h-100" preload="metadata" playsinline
               style="object-fit: contain; background:#000;">
            <source src="{{ $mainVideoSrc }}" type="{{ $videoType }}">
            <source src="{{ $fallbackVideoSrc }}" type="{{ $videoType }}">
            Browser Anda tidak mendukung pemutar video. Silakan unduh secara manual:
            <a href="{{ $mainVideoSrc }}" target="_blank" rel="noopener">
                <i class="fas fa-download me-1"></i> Unduh Video Senam Lansia
            </a>.
        </video>
    </div>

    <p class="text-muted small mt-2 mb-0">
        <i class="fas fa-info-circle"></i>
        Lakukan latihan senam lansia di atas secara rutin minimal <b>3 kali seminggu</b>
        sesuai petunjuk medis, dengan pendampingan keluarga/perawat agar aman.
        <span class="d-block d-sm-inline">
            <i class="fas fa-mouse-pointer ms-1"></i>
            <b>Tips:</b> Klik tombol <i class="fas fa-play"></i> di tengah video untuk memulai.
        </span>
    </p>
</div>
