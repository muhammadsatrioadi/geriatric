@php
$raw = $classificationRaw ?? $classification ?? null;
$c = strtolower(trim((string)$raw));

if ($c === 'tinggi' || $c === 'ringan') {
    $statusKey = 'tinggi';
    $statusLabel = 'Tinggi (Ringan)';
    $badgeClass = 'bg-success';
    $icon = 'fa-smile';
    $accentBorder = 'border-success';
} elseif ($c === 'sedang') {
    $statusKey = 'sedang';
    $statusLabel = 'Sedang';
    $badgeClass = 'bg-warning text-dark';
    $icon = 'fa-meh';
    $accentBorder = 'border-warning';
} else {
    $statusKey = 'rendah';
    $statusLabel = 'Rendah (Berat)';
    $badgeClass = 'bg-danger';
    $icon = 'fa-frown';
    $accentBorder = 'border-danger';
}

$headings = [
    'tinggi' => 'Kondisi fungsi tubuh lansia masih tergolong baik dan mandiri dalam menjalankan Aktivitas Kehidupan Sehari-hari (ADL). Fokus utama latihan adalah mempertahankan kebugaran, menjaga keseimbangan, dan mencegah penurunan fungsi lebih lanjut.',
    'sedang' => 'Kemampuan fungsional sudah mengalami penurunan ringan-sedang. Diperlukan latihan teratur, modifikasi aktivitas, dan perhatian ekstra pada risiko jatuh agar lansia tetap mandiri.',
    'rendah' => 'Terdapat keterbatasan fungsional yang signifikan. Sangat disarankan latihan dengan pendampingan keluarga/caregiver, frekuensi rutin, serta konsultasi medis berkelanjutan untuk menghindari komplikasi.',
];
$heading = $headings[$statusKey];

if ($statusKey === 'tinggi') {
    $items = [
        [
            'title' => 'Frekuensi & Durasi Latihan',
            'content' => '<ul class="mb-0 ps-3">
                <li>Lakukan senam lansia (video di atas) <b>3–4 kali seminggu</b>, 20–30 menit setiap sesi.</li>
                <li>Lengkapi dengan <b>jalan santai 15–30 menit setiap hari</b> (pagi/sore).</li>
                <li>Selalu lakukan <b>pemanasan 5 menit</b> sebelum latihan dan <b>pendinginan/stretching 5 menit</b> sesudah latihan.</li>
            </ul>'
        ],
        [
            'title' => 'Aktivitas Harian yang Disarankan',
            'content' => '<ul class="mb-0 ps-3">
                <li>Terus lakukan <b>ADL secara mandiri</b>: makan, mandi, berpakaian, toileting, berpindah posisi, mobilitas di rumah.</li>
                <li>Aktivitas sosial ringan: berkebun, menyiram tanaman, membersihkan bagian rumah yang ringan, bermain bersama cucu.</li>
                <li>Latihan keseimbangan sederhana: berdiri satu kaki 5–10 detik (berpegangan jika perlu), berjalan tumit menyentuh ujung jari kaki, melangkah maju-mundur.</li>
            </ul>'
        ],
        [
            'title' => 'Pantauan & Nutrisi',
            'content' => '<ul class="mb-0 ps-3">
                <li>Pantau <b>tekanan darah, nadi, dan keluhan nyeri sendi minimal seminggu sekali</b>, catat hasilnya.</li>
                <li>Konsumsi <b>protein cukup</b> (telur, ikan, tempe, tahu, susu lansia), <b>sayur dan buah 5 porsi/hari</b>, minum air putih 1.5–2 liter/hari.</li>
                <li>Cukup <b>tidur 7–8 jam</b>, hindari begadang, kelola stres dengan kegiatan positif.</li>
            </ul>'
        ],
        [
            'title' => 'Peringatan & Tanda Bahaya',
            'content' => '<ul class="mb-0 ps-3">
                <li>Jika muncul <b>nyeri dada, sesak napas berat, pusing parah, pandangan berputar</b> saat latihan → segera berhenti dan istirahat.</li>
                <li>Apabila keluhan berlanjut lebih dari 15 menit → segera hubungi dokter atau puskesmas terdekat.</li>
                <li>Hindari latihan fisik berat saat kondisi badan kurang fit, demam, atau setelah makan besar.</li>
            </ul>'
        ],
    ];
} elseif ($statusKey === 'sedang') {
    $items = [
        [
            'title' => 'Frekuensi & Durasi Latihan',
            'content' => '<ul class="mb-0 ps-3">
                <li>Lakukan senam lansia sesuai video di atas <b>3 kali seminggu</b>, 15–20 menit setiap sesi (tidak perlu dipaksa).</li>
                <li>Latihan <b>selalu didampingi</b> keluarga atau caregiver jika cepat lemas atau kaki gemetar.</li>
                <li>Tambahkan <b>latihan napas dalam dan relaksasi otot</b> setiap pagi & sore, 5–10 menit per sesi.</li>
            </ul>'
        ],
        [
            'title' => 'Aktivitas Harian yang Disarankan',
            'content' => '<ul class="mb-0 ps-3">
                <li>Dorong mandiri ADL yang masih mampu: makan sendiri, berpakaian, duduk dari ranjang → berdiri ke kursi.</li>
                <li>Bantu bagian yang sulit (berjalan berpegangan pada dinding/pegang tangan pendamping, memakai sepatu, mengikat tali).</li>
                <li>Latihan pernapasan diafragma: tarik napas hidung 4 hitungan, tahan 2, hembus pelan 6 hitungan → 10x/hari.</li>
                <li>Latihan duduk-berdiri dari kursi (tanpa menggunakan pegangan tangan bila mampu) → 5–8 kali per hari, bertahap.</li>
            </ul>'
        ],
        [
            'title' => 'Pantauan & Nutrisi',
            'content' => '<ul class="mb-0 ps-3">
                <li>Pantau <b>tekanan darah 2 kali seminggu</b>, <b>catat kejadian jatuh atau hampir jatuh</b>, <b>catat jumlah langkah/hari</b> (target 2000–4000 langkah per hari).</li>
                <li>Nutrisi <b>tinggi protein dan kalsium</b>: susu tinggi kalsium, sayuran hijau, ikan salmon/tuna, kacang-kacangan.</li>
                <li>Konsumsi <b>vitamin D dan kalsium</b> sesuai anjuran dokter (penting untuk tulang dan otot lansia).</li>
            </ul>'
        ],
        [
            'title' => 'Peringatan & Tanda Bahaya',
            'content' => '<ul class="mb-0 ps-3">
                <li>Jangan paksa beraktivitas sendirian saat merasa <b>pusing, tungkai lemas berat, riwayat stroke/jantung, penglihatan kabur</b>.</li>
                <li>Gunakan <b>alat bantu jalan (tongkat)</b> jika dokter menyarankan — jangan malu untuk keamanan.</li>
                <li>Risiko jatuh mulai meningkat → <b>perbaiki pencahayaan rumah</b>, pasang <b>handrail di kamar mandi</b>, hindari keset/karpet licin, kabel di lantai.</li>
            </ul>'
        ],
    ];
} else {
    $items = [
        [
            'title' => 'Frekuensi & Durasi Latihan (WAJIB DIDAMPINGI)',
            'content' => '<ul class="mb-0 ps-3">
                <li>Lakukan senam lansia sesuai video di atas <b>SECARA BERTAHAP</b>, <b>2–3 kali seminggu</b>, 10–15 menit per sesi.</li>
                <li><b>SELALU ditemani keluarga/caregiver</b> yang mampu menolong jika terjadi pingsan, nyeri dada, atau jatuh.</li>
                <li>Latihan <b>pernapasan dalam</b> setiap pagi & sore, 5–10 menit per sesi. Gerakan perlahan, jangan dipaksa.</li>
            </ul>'
        ],
        [
            'title' => 'Aktivitas Harian yang Disarankan',
            'content' => '<ul class="mb-0 ps-3">
                <li>Fokus mempertahankan kemampuan yang masih ada, lakukan <b>latihan rentang gerak sendi (ROM)</b> pasif/aktif ringan 10–15 menit/hari.</li>
                <li>Latihan transisi: <b>Duduk dari tempat tidur → berdiri ke kursi</b> dengan bantuan, 3–5 kali per hari, bertahap. Beri pegangan kuat.</li>
                <li><b>Stimulasi kognitif ringan</b> setiap hari: mengobrol tentang kenangan, bermain tebak kata, membaca berita, mengingat nama anggota keluarga, menghitung uang.</li>
                <li>Hindari berjalan sendirian meskipun merasa mampu — selalu mintakan pendampingan.</li>
            </ul>'
        ],
        [
            'title' => 'Pantauan & Nutrisi',
            'content' => '<ul class="mb-0 ps-3">
                <li>Pantau <b>TTV (Tekanan Darah, Suhu, Nadi, Pernapasan) setiap pagi & sore</b>, catat hasilnya.</li>
                <li>Catat <b>asupan makan & minum</b> agar tidak dehidrasi — target cairan <b>1.2–1.5 liter/hari</b> (sesuai petunjuk dokter jantung/gagal jantung).</li>
                <li>Makanan <b>lunak/lembut jika sulit menelan</b>, frekuensi sering porsi kecil, protein cukup. Konsultasi <b>Ahli Gizi</b> jika penurunan berat badan drastis.</li>
            </ul>'
        ],
        [
            'title' => 'Peringatan & Tanda Bahaya (PENTING)',
            'content' => '<ul class="mb-0 ps-3">
                <li><b class="text-danger">JANGAN</b> memaksa lansia berdiri atau berjalan sendirian <b>TANPA PENAMPUNGAN</b>.</li>
                <li>Jika muncul <b class="text-danger">nyeri hebat, napas pendek, keringat dingin, bicara pelo, badan lemas separuh, wajah mencong, penurunan kesadaran</b> → <b>SEGERA KE IGD RUMAH SAKIT</b>.</li>
                <li>Konsultasi berkala <b>dokter spesialis geriatri/penyakit dalam</b> evaluasi fungsi jantung, paru, tulang → <b>minimal 3 bulan sekali</b>.</li>
            </ul>'
        ],
    ];
}
@endphp

<div class="card mt-4 shadow-sm border">
    <div class="card-header d-flex align-items-center flex-wrap justify-content-between bg-white">
        <h5 class="card-title mb-0 fw-bold">
            <i class="fas fa-clipboard-list"></i>
            Rekomendasi Tertulis
            <span class="badge ms-2 {{ $badgeClass }} rounded-pill" style="font-size: 0.85em;">
                <i class="fas {{ $icon }} me-1"></i>Status: {{ $statusLabel }}
            </span>
        </h5>
    </div>
    <div class="card-body">
        <p class="text-muted border-bottom pb-3 mb-3">{{ $heading }}</p>
        <div class="row g-3">
            @foreach($items as $i => $item)
            <div class="col-md-6">
                <div class="card h-100 border border-start border-4 {{ $accentBorder }}">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2">
                            <span class="badge rounded-pill me-2 {{ $badgeClass }}">
                                {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            {{ $item['title'] }}
                        </h6>
                        <div class="small text-secondary lh-lg">{!! $item['content'] !!}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="alert alert-info mt-4 mb-0 small border-start border-4 border-info">
            <i class="fas fa-user-md me-1"></i>
            <b>Catatan Penting:</b> Rekomendasi di atas bersifat edukatif dan tidak menggantikan diagnosis, terapi, atau saran medis profesional dari dokter.
            Konsultasikan selalu dengan <b>dokter keluarga, dokter spesialis geriatri, fisioterapis, atau perawat lansia</b> untuk rencana latihan dan terapi personal sesuai kondisi medis masing-masing lansia.
        </div>
    </div>
</div>
