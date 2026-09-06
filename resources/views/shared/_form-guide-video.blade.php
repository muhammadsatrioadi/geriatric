@if($video)
    <div class="video-player-card mb-3">
        <div class="video-player-header">
            <i class="fa fa-play-circle"></i>
            <span>Video Panduan: {{ $video->judul }}</span>
        </div>
        <div class="video-wrapper">
            <video controls class="video-player" preload="metadata" playsinline>
                <source src="{{ $video->video_url }}" type="{{ $video->file_type }}">
                Browser Anda tidak mendukung pemutar video.
            </video>
        </div>
    </div>
@endif
