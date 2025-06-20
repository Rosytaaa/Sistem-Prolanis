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

<style>
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
                <a href="/menupasien" class="nav-link toggle-menu active" data-target="#pasienMenu">
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

    <main class="flex-grow-1 bg-light p-4">
        <h1 class="mt-4 ms-4">Menu Pasien</h1>
        <ol class="breadcrumb mb-4 ms-4">
            <li class="breadcrumb-item active">Data Pasien</li>
        </ol>

        <!-- START DATA -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            @if(session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif
                <!-- FORM PENCARIAN -->
                <div class="d-flex justify-content-between align-items-center mb-4 mt-4 flex-wrap gap-2">
                <!-- Kolom Kiri: Search -->
                <form class="d-flex" action="{{ url('menupasien') }}" method="get">
                    <input class="form-control form-control-sm me-2" type="search" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="Masukkan kata kunci" aria-label="Search" style="width: 200px;">
                    <button class="btn btn-sm btn-secondary" type="submit">Cari</button>
                </form>

                <!-- Kolom Kanan: Filter -->
                <form action="{{ url('menupasien') }}" method="get" class="d-flex align-items-center gap-2">
                    <select name="keterangan" id="keterangan" class="form-select form-select-sm" style="width: 160px;">
                        <option value="">-- Semua --</option>
                        <option value="diabetes" {{ request('keterangan') == 'diabetes' ? 'selected' : '' }}>Diabetes</option>
                        <option value="hipertensi" {{ request('keterangan') == 'hipertensi' ? 'selected' : '' }}>Hipertensi</option>
                        <option value="diabetes melitus dan hipertensi" {{ request('keterangan') == 'diabetes melitus dan hipertensi' ? 'selected' : '' }}>Hipertensi & Diabetes</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
                </form>
                </div>

                <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ url('/import-pasien') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importModalLabel">Import Data Pasien</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Pilih File Excel</label>
                                        <input type="file" class="form-control" name="file" id="file" accept=".xls,.xlsx,.csv" required>
                                    </div>
                                    <small class="text-muted">*Pastikan format sesuai template (Excel / CSV)</small>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Import</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5 mb-2">
                    <!-- TOMBOL TAMBAH DATA -->
                    <div>
                        @if(!in_array(auth()->user()->role, ['pimpinan']))
                        <a href='/createpasien' class="btn btn-primary">+ Tambah Data</a>
                        @endif
                    </div>

                    <!-- TOMBOL EXPORT & IMPORT -->
                    <div>
                        @if(!in_array(auth()->user()->role, ['perawat']))
                        <a href="/export-pasien" class="btn btn-danger me-2">
                            <i class="fa-solid fa-upload me-2"></i>Export
                        </a>
                        @endif

                        @if(!in_array(auth()->user()->role, ['pimpinan']))
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fa-solid fa-download me-2"></i>Import
                        </button>
                        @endif 
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 10%;">No BPJS</th>
                            <th style="width: 15%;">Nama</th>
                            <th style="width: 10%;">Jenis Kelamin</th>
                            <th style="width: 10%;">Tanggal Lahir</th>
                            <th style="width: 15%;">Keterangan</th>
                            <th style="width: 10%;">No Telepon</th>
                            <th style="width: 20%;">Alamat</th> <!-- Kolom alamat lebih lebar -->
                            <th style="width: 10%;" class="text-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr onclick="window.location='{{ route('menupasien.show', $item->no_bpjs) }}'" style="cursor: pointer;">
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{{ $item->no_bpjs }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jenis_kelamin}}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>{{ $item->no_telepon }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td class="text-nowrap">
                                <a href="{{ url('menupasien/' . $item->no_bpjs . '/edit') }}" class="fa-regular fa-pen-to-square btn btn-warning btn-sm"></a>
                                <form onsubmit="return confirm('Apakah kamu yakin ingin menghapus data ini?')" class='d-inline' action="{{ url('menupasien/'. $item->no_bpjs) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="event.stopPropagation()" class="fa-solid fa-trash btn btn-danger btn-sm"></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
            {{ $data->withQueryString()->links('pagination::bootstrap-5') }}
          </div>
    </main>
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
</script>
</body>
</html>

