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
                <span class="nav-link">{{ Auth::user()->name }}</span><!-- Menampilkan nama user yang login -->
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

    <div class="container bg-light">
        <h1 class="mt-4 ms-4">Menu Pasien</h1>
        <ol class="breadcrumb mb-4 ms-4">
            <li class="breadcrumb-item active">Data Pasien</li>
        </ol>

        <body class="bg-light">
            <main class="container">
            <!-- START FORM -->
            @if ($errors->any())
            <div class="pt-3">
                <div class="alert alert-danger w-auto">
                    <ul>
                        @foreach ($errors->all() as $item)
                            <li> {{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <form action="{{ route('menupasien.store') }}" method="post">
            @csrf
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <div class="mb-3 row">
                    <label for="no_bpjs" class="col-sm-2 col-form-label">No BPJS</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name='no_bpjs' id="no_bpjs" value="{{ old('no_bpjs')}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='nama' id="nama" value="{{ old('nama')}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                            <option value="">--Pilih--</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="keterangan" id="keterangan" required>
                            <option value="">-- Pilih Keterangan --</option>
                            <option value="Diabetes Melitus" {{ old('keterangan') == 'Diabetes' ? 'selected' : '' }}>Diabetes Melitus</option>
                            <option value="Hipertensi" {{ old('keterangan') == 'Hipertensi' ? 'selected' : '' }}>Hipertensi</option>
                            <option value="Diabetes Melitus dan Hipertensi" {{ old('keterangan') == 'Diabetes Melitus dan Hipertensi' ? 'selected' : '' }}>Diabetes Melitus dan Hipertensi</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jurusan" class="col-sm-2 col-form-label">No Telepon</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name='no_telepon' id="no_telepon" value="{{ old('no_telepon')}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jurusan" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='alamat' id="alamat" value="{{ old('alamat')}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jurusan" class="col-sm-2 col-form-label"></label>
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                        <a href="{{ route('menupasien.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
              </form>
            </div>
        </main>
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
</script>

    </div>
</body>
</html>
