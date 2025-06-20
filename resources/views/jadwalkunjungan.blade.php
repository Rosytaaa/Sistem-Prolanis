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
*
    body{
        background-color: #eaeaea;
    }
    .sidebar {
        width: 280px;
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
    <div class="d-flex min-vh-100">
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
                        <a href="/hasillab" class="nav-link">Hasil Lab</a>
                        <a href="/jadwalkunjungan" class="nav-link acti">Jadwal Kunjungan</a>
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
        <h1 class="mt-4 ms-4">Menu Pemeriksaan</h1>
        <ol class="breadcrumb mb-4 ms-4">
            <li class="breadcrumb-item active">Jadwal Kunjungan</li>
        </ol>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            @if(session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
            @endif
                <!-- FORM PENCARIAN -->
               <div class="d-flex justify-content-between align-items-center mb-4 mt-4 flex-wrap gap-2">
                <!-- Kolom Kiri: Search -->
                <form class="d-flex" action="{{ url('jadwalkunjungan') }}" method="get">
                    <input class="form-control form-control-sm me-2" type="search" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="Masukkan kata kunci" aria-label="Search" style="width: 200px;">
                    <button class="btn btn-sm btn-secondary" type="submit">Cari</button>
                </form>

                <!-- Kolom Kanan: Filter -->
                <form action="{{ url('jadwalkunjungan') }}" method="get" class="d-flex align-items-center gap-2">
                    <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}" class="form-control form-control-sm" style="width: 150px;">
                    <select name="keterangan" id="keterangan" class="form-select form-select-sm" style="width: 160px;">
                        <option value="">-- Semua --</option>
                        <option value="diabetes" {{ request('keterangan') == 'diabetes' ? 'selected' : '' }}>Diabetes</option>
                        <option value="hipertensi" {{ request('keterangan') == 'hipertensi' ? 'selected' : '' }}>Hipertensi</option>
                        <option value="diabetes melitus dan hipertensi" {{ request('keterangan') == 'diabetes melitus dan hipertensi' ? 'selected' : '' }}>Hipertensi & Diabetes</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
                </form>
            </div>
            <div class="pb-3">
                @if(!in_array(auth()->user()->role, ['pimpinan']))
                <a href="{{ route('jadwalkunjungan.create') }}" class="btn btn-primary">+ Tambah Data</a>
                @endif
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 10%;">No BPJS</th>
                        <th style="width: 15%;">Nama</th>
                        <th style="width: 12%;">Keterangan</th>
                        <th style="width: 10%;">No Telepon</th>
                        <th style="width: 15%;">Jadwal Kunjungan</th>
                        <th style="width: 15%;">Catatan</th>
                        <th style="width: 10%;" class="text-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr onclick="window.location='{{ route('jadwalkunjungan.show', $item->id) }}'" style="cursor: pointer;">
                        <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                        <td>{{ $item->no_bpjs }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->keterangan}}</td>
                        <td>{{ $item->no_telepon }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->jadwal_pemeriksaan)->format('d/m/Y H:i') }}</td>
                        <td>{{ $item->catatan }}</td>
                        <td class="text-nowrap">
                        <div class="d-flex align-items-center gap-1">
                        @php
                            $nomorWa = '62' . ltrim($item->no_telepon, '0');
                            $jadwal = \Carbon\Carbon::parse($item->jadwal_pemeriksaan);
                            $tanggal = $jadwal->format('d F Y');
                            $jam = $jadwal->format('H:i');

                            // Format pesan WhatsApp
                            $pesan = "Yth Bapak/Ibu {$item->nama},\n\n";
                            $pesan .= "Kami dari Klinik Pratama Firdaus ingin mengingatkan bahwa Anda memiliki jadwal pemeriksaan pada:\n\n";
                            $pesan .= "Tanggal: {$tanggal}\n";
                            $pesan .= "Jam: {$jam} WIB\n";
                            $pesan .= "Tempat: Klinik Pratama Firdaus\n";

                            if (!empty($item->catatan)) {
                                $pesan .= "Catatan: {$item->catatan}\n\n";
                            }

                            $pesan .= "Mohon hadir 10–15 menit lebih awal untuk proses administrasi.\n";
                            $pesan .= "Terima kasih atas perhatian Anda. Jika ada pertanyaan, silakan hubungi kami di sini.";

                            $pesan_encoded = urlencode($pesan);
                        @endphp

                            <a href="https://wa.me/{{ $nomorWa }}?text={{ $pesan_encoded }}"
                                target="_blank"
                                class="btn btn-success btn-sm d-inline-flex justify-content-center align-items-center"
                                onclick="event.stopPropagation();">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>

                            <a href="{{ url('jadwalkunjungan/' . $item->id . '/edit') }}" class="btn btn-warning btn-sm d-inline-flex justify-content-center align-items-center">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>

                            <form onsubmit="return confirm('Apakah kamu yakin ingin menghapus data ini?')" class='d-inline' action="{{ url('jadwalkunjungan/'. $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="event.stopPropagation()" class="fa-solid fa-trash btn btn-danger btn-sm"></button>
                            </form>
                         </div>
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
        link.addEventListener('click', function (e) {
            e.preventDefault(); // biar gak redirect #

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
