@extends('foundation.layouts.layout')

@section('foundation_title', 'Dashboard')
@section('foundation_page_title', 'Dashboard Yayasan')

@section('foundation_layout')
    <!-- Success Message -->
    @if (session('success'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Dashboard Content -->
    <div id="dashboard-content">
        <!-- Welcome Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fas fa-building"></i> Selamat Datang di {{ $foundation->name }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Dashboard ini menampilkan statistik dan data pasien yayasan Anda. 
                            Kelola data pasien, lihat hasil pemeriksaan, dan pantau perkembangan kesehatan lansia.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="card card-stats card-primary card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Pasien</p>
                                    <h4 class="card-title">{{ $totalPasien }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats card-info card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-video"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Video</p>
                                    <h4 class="card-title">{{ $totalVideo }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats card-success card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Pasien Ringan</p>
                                    <h4 class="card-title">{{ $ringanCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats card-warning card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Pasien Berat</p>
                                    <h4 class="card-title">{{ $beratCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Pie Chart -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fas fa-chart-pie"></i> Distribusi Klasifikasi Pasien
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fas fa-chart-bar"></i> Statistik Per Tes
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Patients -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fas fa-list"></i> Pasien Terbaru
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Umur</th>
                                        <th>Klasifikasi</th>
                                        <th>Public Visible</th>
                                        <th>Tanggal Pemeriksaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPatients as $patient)
                                    <tr>
                                        <td>{{ $patient->nama }}</td>
                                        <td>{{ $patient->nik }}</td>
                                        <td>{{ \Carbon\Carbon::parse($patient->tanggal_lahir)->age }} tahun</td>
                                        <td>
                                            @if($patient->klasifikasi == 'Ringan')
                                                <span class="badge badge-success">Ringan</span>
                                            @elseif($patient->klasifikasi == 'Sedang')
                                                <span class="badge badge-warning">Sedang</span>
                                            @else
                                                <span class="badge badge-danger">Berat</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($patient->public_visible)
                                                <span class="badge badge-success">Ya</span>
                                            @else
                                                <span class="badge badge-secondary">Tidak</span>
                                            @endif
                                        </td>
                                        <td>{{ $patient->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('foundation.pasiens.show', $patient) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('foundation.pasiens.manage', $patient) }}" 
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada data pasien</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Pasien Tab Content -->
    <div class="row" id="pasiens-content" style="display: none;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="fas fa-users"></i> Data Pasien
                    </h4>
                    <a href="{{ route('foundation.pasiens.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pasien
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="pasiens-table" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Klasifikasi</th>
                                    <th>Public Visible</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allPasiens ?? [] as $pasien)
                                <tr>
                                    <td>{{ $pasien->nik }}</td>
                                    <td>{{ $pasien->nama }}</td>
                                    <td>{{ $pasien->tanggal_lahir->format('d/m/Y') }}</td>
                                    <td>{{ $pasien->jenis_kelamin }}</td>
                                    <td>
                                        @if($pasien->klasifikasi == 'Ringan')
                                            <span class="badge badge-success">Ringan</span>
                                        @elseif($pasien->klasifikasi == 'Sedang')
                                            <span class="badge badge-warning">Sedang</span>
                                        @else
                                            <span class="badge badge-danger">Berat</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pasien->public_visible)
                                            <span class="badge badge-success">Ya</span>
                                        @else
                                            <span class="badge badge-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('foundation.pasiens.show', $pasien->id) }}"
                                            class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('foundation.pasiens.manage', $pasien->id) }}"
                                            class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('foundation.pasiens.destroy', $pasien->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus data pasien ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data pasien</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        const dashboardContent = document.getElementById('dashboard-content');
        const pasiensContent = document.getElementById('pasiens-content');
        const dashboardTab = document.getElementById('dashboard-tab');
        const pasiensTab = document.getElementById('pasiens-tab');

        // Show dashboard content by default
        if (dashboardContent) {
            dashboardContent.style.display = 'block';
        }
        if (pasiensContent) {
            pasiensContent.style.display = 'none';
        }

        // Tab click handlers
        if (dashboardTab) {
            dashboardTab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Update tab states
                dashboardTab.classList.add('active');
                if (pasiensTab) pasiensTab.classList.remove('active');
                dashboardTab.setAttribute('aria-selected', 'true');
                if (pasiensTab) pasiensTab.setAttribute('aria-selected', 'false');
                
                // Show dashboard content
                if (dashboardContent) dashboardContent.style.display = 'block';
                if (pasiensContent) pasiensContent.style.display = 'none';
                
                // Update URL without page reload
                window.history.pushState({}, '', '{{ route("foundation.dashboard") }}');
            });
        }

        if (pasiensTab) {
            pasiensTab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Update tab states
                pasiensTab.classList.add('active');
                if (dashboardTab) dashboardTab.classList.remove('active');
                pasiensTab.setAttribute('aria-selected', 'true');
                if (dashboardTab) dashboardTab.setAttribute('aria-selected', 'false');
                
                // Show pasiens content
                if (pasiensContent) pasiensContent.style.display = 'block';
                if (dashboardContent) dashboardContent.style.display = 'none';
                
                // Update URL without page reload
                window.history.pushState({}, '', '{{ route("foundation.pasiens") }}');
                
                // Initialize DataTable if not already initialized
                if (!$.fn.DataTable.isDataTable('#pasiens-table')) {
                    $('#pasiens-table').DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.0/i18n/id.json'
                        },
                        pageLength: 10,
                        order: [[1, 'asc']],
                        responsive: true
                    });
                }
            });
        }

        // Check if we're on pasiens route and show appropriate tab
        if (window.location.pathname.includes('/pasiens')) {
            if (pasiensTab && pasiensContent) {
                // Small delay to ensure DOM is ready
                setTimeout(() => {
                    pasiensTab.click();
                }, 100);
            }
        }

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function() {
            if (window.location.pathname.includes('/pasiens')) {
                if (pasiensTab && pasiensContent) {
                    pasiensTab.click();
                }
            } else {
                if (dashboardTab && dashboardContent) {
                    dashboardTab.click();
                }
            }
        });

        // Handle alert dismissal
        const alerts = document.querySelectorAll('.alert-dismissible .close');
        alerts.forEach(alert => {
            alert.addEventListener('click', function() {
                const alertContainer = this.closest('.alert');
                if (alertContainer) {
                    alertContainer.remove();
                }
            });
        });
    });

    // Pie Chart
    var pieCtx = document.getElementById('pieChart');
    if (pieCtx) {
        var pieChart = new Chart(pieCtx.getContext('2d'), {
            type: 'pie',
            data: {
                labels: @json($pieChartLabels),
                datasets: [{
                    data: @json($pieChartData),
                    backgroundColor: @json($pieChartColors),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.parsed || 0;
                                var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                var percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // Bar Chart
    var barCtx = document.getElementById('barChart');
    if (barCtx) {
        var barChart = new Chart(barCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($testStats['labels']),
                datasets: [{
                    label: 'Normal',
                    data: @json($testStats['normal']),
                    backgroundColor: '#10B981',
                    borderColor: '#10B981',
                    borderWidth: 1
                }, {
                    label: 'Tidak Normal',
                    data: @json($testStats['abnormal']),
                    backgroundColor: '#EF4444',
                    borderColor: '#EF4444',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }
</script>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.0/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap4.min.js"></script>
@endpush
