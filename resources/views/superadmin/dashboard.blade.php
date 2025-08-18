@extends('superadmin.layouts.layout')
@section('superadmin_title')
    Dashboard
@endsection
@section('superadmin_page_title')
    Dashboard
@endsection
@section('superadmin_layout')
    <h1 class="mb-4">
        Selamat Datang 👋
    </h1>
    <p class="mb-4">
        Hai, selamat datang. Silakan gunakan menu di samping untuk mengelola data.
    </p>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $totalPasien }}</h4>
                            <p class="card-text">Total Pasien</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $totalAdmin }}</h4>
                            <p class="card-text">Total Admin</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-user-shield fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $totalFoundation }}</h4>
                            <p class="card-text">Total Yayasan</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-building fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $totalVideo }}</h4>
                            <p class="card-text">Total Video</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-video fa-2x"></i>
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
                    <h5 class="card-title">Distribusi Klasifikasi Pasien</h5>
                </div>
                <div class="card-body">
                    <canvas id="pieChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Statistik Hasil Tes</h5>
                </div>
                <div class="card-body">
                    <canvas id="barChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <!-- Chart.js Local -->
    <script src="{{ asset('js/chart.min.js') }}"></script>

    <script>
        // Pie Chart Data
        const pieData = @json($pieChartData);
        const pieLabels = @json($pieChartLabels);
        const pieColors = @json($pieChartColors);

        // Bar Chart Data
        const testStats = @json($testStats);

        // Create Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieData,
                    backgroundColor: pieColors,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Create Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Barthel Index', '2-Minute Step Test', 'Single Leg Balance', 'Five Times Sit to Stand'],
                datasets: [
                    {
                        label: 'Normal',
                        data: [
                            testStats.barthel.normal,
                            testStats.step_test.normal,
                            testStats.single_leg.normal,
                            testStats.sit_to_stand.normal
                        ],
                        backgroundColor: '#10B981',
                        borderColor: '#10B981',
                        borderWidth: 1
                    },
                    {
                        label: 'Tidak Normal',
                        data: [
                            testStats.barthel.abnormal,
                            testStats.step_test.abnormal,
                            testStats.single_leg.abnormal,
                            testStats.sit_to_stand.abnormal
                        ],
                        backgroundColor: '#EF4444',
                        borderColor: '#EF4444',
                        borderWidth: 1
                    }
                ]
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
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
