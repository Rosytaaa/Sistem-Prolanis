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
    <link rel="stylesheet" href="css/hasillab.css">

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
        padding-right: 10px;
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
        color: #000;
        text-decoration: none;
    }
    .dropdown img {
        margin-right: 10px;
    }.custom-btn {
        background-color: #198754;
        color: white;
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
                    <a href="/dashboard" class="nav-link">
                        <i class="fa-solid fa-house"></i> <span>Dashboard</span>
                    </a>
                </li>

                <!-- Menu Pasien -->
                <li>
                    <a href="/menupasien" class="nav-link" data-target="#pasienMenu">
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
                        <a href="/hasillab" class="nav-link active">Hasil Lab</a>
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

        <main class="flex-grow-1 bg-light p-4">
            <h1 class="mt-4 ms-4">Menu Hasil Lab</h1>
            <ol class="breadcrumb mb-4 ms-4">
                <li class="breadcrumb-item">Detail Pemeriksaan</li>
            </ol>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="container">
                            <div class="card-body">
                                <div class="row">
                                <h5 class="mt-2 mb-3" >Data Pasien</h5>
                                @if (!$data->pasien)
                                    <div class="alert alert-danger">
                                        * Pasien terkait sudah dihapus dari data pasien.
                                    </div>
                                @endif
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="d-flex mb-2">
                                        <div class="fw-semibold me-2" style="min-width: 100px;">No BPJS</div>
                                        <div class="me-2">:</div>
                                        <div>{{ $data->no_bpjs }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-semibold me-2" style="min-width: 100px;">Nama</div>
                                        <div class="me-2">:</div>
                                        <div>{{ $data->nama }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-semibold me-2" style="min-width: 100px;">Jenis Kelamin</div>
                                        <div class="me-2">:</div>
                                        <div>{{ $data->pasien?->jenis_kelamin ?? $data->jenis_kelamin ?? '' }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-semibold me-2" style="min-width: 100px;">Tanggal Lahir</div>
                                        <div class="me-2">:</div>
                                        <div>{{ \Carbon\Carbon::parse($data->tanggal_lahir)->format('d/m/Y') }}</div>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="d-flex mb-2">
                                        <div class="fw-semibold me-2" style="min-width: 100px;">Keterangan</div>
                                        <div class="me-2">:</div>
                                        <div>{{ $data->keterangan }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-semibold me-2" style="min-width: 100px;">No Telepon</div>
                                        <div class="me-2">:</div>
                                        <div>{{ $data->pasien?->no_telepon ?? $data->no_telepon ?? '' }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="fw-semibold me-2" style="min-width: 100px;">Alamat</div>
                                        <div class="me-2">:</div>
                                        <div>{{ $data->pasien?->alamat ?? $data->alamat ?? '' }}</div>
                                    </div>
                                </div>

                                <h5 class="mt-5 mb-3">Hasil Laboratorium</h5>
                                <div class="col-md-6">
                                    <div class="d-flex mb-2">
                                        <div class="fw-semibold me-2" style="width: 180px;">Tanggal Pemeriksaan</div>
                                            <div class="me-2">:</div>
                                            <div>{{ \Carbon\Carbon::parse($data->tanggal_pemeriksaan)->format('d/m/Y') }}</div>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <div class="fw-semibold me-2" style="width: 180px;">Hasil Laboratorium</div>
                                            <div class="me-2">:</div>
                                            <div>{{ $data->hasil_lab }}</div>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <div class="fw-semibold me-2" style="width: 180px;">Catatan</div>
                                            <div class="me-2">:</div>
                                            <div>{{ $data->catatan ? $data->catatan : '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="{{ route('hasillab.index') }}" class="btn btn-secondary m-3">Kembali</a>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
<script>
    document.querySelectorAll('.toggle-menu').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
                let submenu = document.querySelector(this.getAttribute("data-target"));
                let arrow = this.querySelector('.arrow');
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

    window.addEventListener("DOMContentLoaded", () => {
        const currentPath = window.location.pathname;
        const pemeriksaanMenu = document.getElementById("pemeriksaanMenu");
        const pemeriksaanToggle = document.querySelector('[data-target="#pemeriksaanMenu"]');
        const arrow = pemeriksaanToggle.querySelector('.arrow');

        if (currentPath.includes("hasillab") || currentPath.includes("jadwalkunjungan")) {
            pemeriksaanMenu.style.display = "block";
            arrow.classList.remove("fa-angle-right");
            arrow.classList.add("fa-angle-down");
        }

        // Tandai menu aktif berdasarkan URL
        document.querySelectorAll('.submenu a').forEach(link => {
            if (currentPath === link.getAttribute("href")) {
                link.classList.add("active");
            }
        });
    });
</script>
</body>
</html>
