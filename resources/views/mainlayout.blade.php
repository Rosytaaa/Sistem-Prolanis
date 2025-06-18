<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SISTEM PROLANIS</title>
    <link rel="icon" type="image/x-icon"href="{{ asset('myfavicon.ico') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<style>
    body{
        background-color: #eaeaea;
    }
        .sidebar {
            width: 280px;
            height: 100vh;
            background: #f8f9fa;
            padding: 15px;
        }
        .nav-link {
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-link:hover {
            background: #e9ecef;
        }
        .submenu {
            padding-left: 30px;
            display: none;
        }
        .submenu .nav-link {
            background: none;
            color: #333;
            font-size: 14px;
        }
        .submenu .nav-link:hover {
            background: #f1f1f1;
        }
        .brand-text {
            color: black !important;
            text-decoration: none;
        }
        .sidebar img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding-right: 10px; /* Sesuaikan nilai ini untuk menggeser ke kanan */
        }
        .brand-text {
            margin-left: 28px;
            font-weight: 500;
            margin-top: 10px;
        }
        .dropdown {
            display: flex;
            align-items: center;
            margin-top: 25px; /* kasih jarak dari menu atas */
            padding-left: 10px; /* opsional */
        }

        .dropdown a {
            display: flex;
            align-items: center;
            color: #000; /* Warna teks default */
            text-decoration: none;
        }

        .dropdown img {
            margin-right: 10px; /* Beri jarak antara gambar dan teks */
        }

        .card{
            height:150px;
            border:none;

        }
        .card-footer{
            height:40px;
            border: none;
        }
        .card-body{
            margin-left: 10px;
        }
        .fw-bold{
            font-size :50px
        }
        .text-bold{
            font-size: 15px;
        }
        .chart-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 300px; /* batas lebar maksimum isi */
            margin: 0 auto;   /* posisi di tengah */
            }

        canvas {
            max-width: 200px; /* atur ukuran canvas */
            max-height: 200px;
        }
        .chart-legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            margin-left: 10px;
            }
        .chart-legend {
            padding-bottom: 10px; /* beri ruang di bawah legend */
        }

    </style>
</head>

<body>
<div class="d-flex">
    <aside class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-white">
        <img src="/img/logo1.png" alt="Logo" width="100" height="90">
        <a href="/dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none brand-text">
            <span class="fs-4">SISTEM PROLANIS</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link active">
                    <i class="fa-solid fa-house"></i> <span>Dashboard</span>
                </a>
            </li>

            <!-- Menu Pasien -->
            <li>
                <a href="/menupasien" class="nav-link toggle-menu" data-target="#pasienMenu">
                    <i class="fa-solid fa-user"></i> <span>Menu Pasien</span>
                </a>
            </li>

            <!-- Menu Pemeriksaan -->
            <li>
                <a href="#" class="nav-link toggle-menu" data-target="#pemeriksaanMenu">
                    <i class="fa-solid fa-stethoscope"></i> <span>Menu Pemeriksaan</span>
                    <i class="fa-solid fa-angle-right ms-auto arrow"></i>
                </a>
                <div class="submenu" id="pemeriksaanMenu">
                    <a href="/hasillab" class="nav-link">Hasil Lab</a>
                    <a href="/jadwalkunjungan" class="nav-link">Jadwal Kunjungan</a>
                </div>
            </li>
            @if (auth()->user()->role === 'operator')
            <li>
                 <a href="/manajemenuser" class="nav-link toggle-menu" data-target="#menejemenMenu">
                    <i class="fa-solid fa-users-gear"></i> <span>User</span>
                </a>
            </li>
            @endif
        </ul>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown">
                <img src="/img/profile.png" alt="" width="35" height="25" class="rounded-circle me-auto">
                <span class="nav-link">{{ Auth::user()->name }}</span> <!-- Menampilkan nama user yang login -->
            </a>
            <ul class="dropdown-menu text-small shadow">
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sign out
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </div>
    </aside>

    <div class="container">
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
               <div class="col-xl-3 col-md-6">
                    <div class="card bg-white mb-4">
                        <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="text-primary">
                        <h2 class="fw-bold">{{ $totalDiabetes }}</h2> <!-- angka jumlah pasien diabetes -->
                        <div class="text-black text-bold">Diabetes Melitus</div> <!-- teks utama -->
                    </div>
                    <img src="{{ asset('img/diabetes.png') }}" style="width: 60px; height: auto;">
                </div>
                <div class="card-footer bg-primary d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('pasien.diabetes') }}">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-white mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-warning">
                        <h2 class="fw-bold">{{ $totalHipertensi }}</h2> <!-- angka jumlah pasien diabetes -->
                        <div class="text-black text-bold">Hipertensi</div> <!-- teks utama -->
                    </div>
                    <img src="{{ asset('img/hipertensi.png') }}" style="width: 60px; height: auto;">
                </div>
                <div class="card-footer bg-warning d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('pasien.hipertensi') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-white mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-danger">
                        <h2 class="fw-bold">{{ $totalKeduanya }}</h2> <!-- angka jumlah pasien diabetes -->
                        <div class="text-black text-bold" style="font-size: 12px;">Diabetes Melitus dan Hipertensi</div> <!-- teks utama -->
                    </div>
                    <img src="{{ asset('img/keduanya.png') }}" style="width: 60px; height: auto;">
                </div>
                <div class="card-footer bg-danger d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('pasien.keduanya') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-white mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-success">
                        <h2 class="fw-bold">{{ $totalPasien }}</h2> <!-- angka jumlah pasien diabetes -->
                    <div class="text-black text-bold">Jumlah Pasien</div> <!-- teks utama -->
                </div>
                <img src="{{ asset('img/pasien.png') }}" style="width: 60px; height: auto;">
            </div>
            <div class="card-footer bg-success d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('menupasien.index') }}">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    @if(Auth::user()->role !== 'perawat')
    <div class="container mt-3">
        <div class="row">
            <!-- PIE CHART -->
            <div class="col-md-4 mb-4">
                <div class="chart-card bg-white">
                    <div class="chart-body">
                    <h5 class="chart-title text-center">Distribusi Pasien</h5>
                    <canvas id="pieChart"></canvas>
                </div>

                <div class="chart-legend">
                    <div class="chart-legend-item">
                        <span style="width: 15px; height: 10px; background-color: #007bff; display: inline-block;"></span>
                        Diabetes Melitus
                    </div>
                    <div class="chart-legend-item">
                        <span style="width: 15px; height: 10px; background-color: #ffc107; display: inline-block;"></span>
                        Hipertensi
                    </div>
                    <div class="chart-legend-item">
                        <span style="width: 15px; height: 10px; background-color: #dc3545; display: inline-block;"></span>
                        Keduanya
                    </div>
                </div>
            </div>
        </div>

            <!-- BAR CHART -->
        <div class="col-md-8 mb-4">
            <div class="chart-card bg-white">
                <div class="chart-body" style="min-height: 280px; padding-top: 20px;">
                    <h5 class="chart-title text-center" style="white-space: nowrap;">Pemeriksaan Pasien per Bulan</h5>
                    <canvas id="barChart" style="max-height: 270px;"></canvas>
                </div>
            </div>
        </div>
        @endif
        </div>
    </div>


<script>
    document.querySelectorAll('.toggle-menu').forEach(link => {
        link.addEventListener('click', function() {
            let submenu = document.querySelector(this.getAttribute("data-target"));
            let arrow = this.querySelector('.arrow');

            // Toggle submenu
            if (submenu.style.display === "none" || submenu.style.display === "") {
                submenu.style.display = "block";
                arrow.classList.remove("fa-angle-right");
                arrow.classList.add("fa-angle-down");
            } else {
                submenu.style.display = "none";
                arrow.classList.remove("fa-angle-down");
                arrow.classList.add("fa-angle-right");
            }

        });
    });

    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Diabetes Melitus', 'Hipertensi', 'Keduanya'],
            datasets: [{
                label: 'Jumlah Pasien',
                data: [
                    {{ $totalDiabetes }},
                    {{ $totalHipertensi }},
                    {{ $totalKeduanya }}
                ],
                backgroundColor: ['#007bff', '#ffc107', '#dc3545'],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                display: false
                }
            }
        }
    });

    const labels = {!! json_encode($pemeriksaanPerBulan->pluck('bulan')) !!};
    const data = {!! json_encode($pemeriksaanPerBulan->pluck('jumlah')) !!};

    const ctx = document.getElementById('barChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pasien',
                data: data,
                backgroundColor: '#007bff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // ✅ Tambahkan ini
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
</body>
</html>
