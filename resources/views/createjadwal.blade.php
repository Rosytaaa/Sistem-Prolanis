<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SISTEM PROLANIS</title>
    <link rel="icon" type="image/x-icon"href="{{ asset('myfavicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

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

                <li>
                    <a href="/menupasien" class="nav-link" data-target="#pasienMenu">
                        <i class="fa-solid fa-user"></i> <span>Menu Pasien</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="nav-link toggle-menu" data-target="#pemeriksaanMenu">
                        <i class="fa-solid fa-stethoscope"></i> <span>Menu Pemeriksaan</span>
                        <i class="fa-solid fa-angle-right ms-auto arrow"></i>
                    </a>
                    <div class="submenu" id="pemeriksaanMenu">
                        <a href="/hasillab" class="nav-link">Hasil Lab</a>
                        <a href="/jadwalkunjungan" class="nav-link active">Jadwal Kunjungan</a>
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
            <h1 class="mt-4 ms-4">Menu Jadwal Kunjungan</h1>
            <ol class="breadcrumb mb-4 ms-4">
                <li class="breadcrumb-item active">Input Jadwal Kunjungan</li>
            </ol>

            <body class="bg-light">
                <main class="container">
                    @if ($errors->any())
                    <div class="pt-3">
                        <div class=   "alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $hasil)
                                <li>{{ $hasil }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('jadwalkunjungan.store') }}" method="POST">
                    @csrf
                    <div class="my-3 p-3 bg-body rounded shadow-sm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 row align-items-center">
                                    <label for="search_pasien" class="col-sm-3 col-form-label">No BPJS</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="search_pasien" class="form-control" placeholder="Ketik No BPJS atau Nama">
                                        <input type="hidden" name="no_bpjs" id="no_bpjs" value="{{ old('no_bpjs') }}">
                                        <div id="list_pasien" class="list-group mt-1" style="position: absolute; z-index: 1000;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="alamat_input" value="{{ old('alamat') }}" name="alamat" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-3 col-form-label">Nama Pasien</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="nama_input" value="{{ old('nama') }}" name="nama" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-3 col-form-label">No Telepon</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="no_telepon" value="{{ old('no_telepon') }}"name="no_telepon" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="tgl_lahir" value="{{ old('tanggal_lahir') }}"name="tanggal_lahir" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="jk_input" value="{{ old('jenis_kelamin') }}"name="jenis_kelamin" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-3 col-form-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="keterangan" value="{{ old('keterangan') }}"name="keterangan" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-5 mb-4">Jadwal Kunjungan</h5>
                            <div class="col-md-6">
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-3 col-form-label">Jadwal Kunjungan</label>
                                    <div class="col-sm-9">
                                        <input type="datetime-local" name="jadwal_pemeriksaan" value="{{ old('jadwal_pemeriksaan') }}"name="jadwal_pemeriksaan" class="form-control" id="jadwal_pemeriksaan">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row mt-5">
                                <label for="catatan" class="col-sm-2 col-form-label">Catatan</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="catatan" id="catatan" rows="3" placeholder="Opsional...">{{ old('catatan') }}</textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="mb-3">
                                    <label for="jurusan" class="col-sm-2 col-form-label"></label>
                                    <div class="d-flex justify-content-center gap-3 mt-4">
                                        <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                                        <a href="{{ route('jadwalkunjungan.index') }}" class="btn btn-secondary">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </main>
            </div>
    </div>
</div>

<script>
function tambahData() {
    const jenis = document.getElementById('jenis_pemeriksaan').value;
    const hasil = document.getElementById('hasil_pemeriksaan').value;

    if (jenis === '' || hasil === '') {
        alert("Mohon isi kedua kolom!");
        return;
    }

    const tbody = document.getElementById('tbody_hasil');

    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td></td>
        <td>
            ${jenis}
            <input type="hidden" name="jenis_pemeriksaan[]" value="${jenis}">
        </td>
        <td>
            ${hasil}
            <input type="hidden" name="hasil_pemeriksaan[]" value="${hasil}">
        </td>
        <td class="text-nowrap">
            <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </td>

    `;

    tbody.appendChild(tr);
    perbaruiNomor();

    // Bersihkan input
    document.getElementById('jenis_pemeriksaan').value = '';
    document.getElementById('hasil_pemeriksaan').value = '';
}

function hapusBaris(button) {
    const row = button.closest('tr');
    row.remove();
    perbaruiNomor();
}

function perbaruiNomor() {
    const rows = document.querySelectorAll('#tbody_hasil tr');
    rows.forEach((row, index) => {
        row.children[0].textContent = index + 1;
    });
}
    $(document).ready(function() {
        var dataPasien = [
            @foreach($pasien as $p)
                "{{ $p->no_bpjs }} - {{ $p->nama }}",
            @endforeach
        ];

        $("#no_bpjs_input").autocomplete({
            source: dataPasien,
            minLength: 1
        });
    });

    const pasienList = @json($pasien);

    const searchInput = document.getElementById('search_pasien');
    const listPasienDiv = document.getElementById('list_pasien');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        listPasienDiv.innerHTML = '';

        if (query.length === 0) {
            return;
        }

        // Filter pasien berdasarkan no_bpjs atau nama
        const filteredPasien = pasienList.filter(p =>
            p.no_bpjs.toLowerCase().includes(query) ||
            p.nama.toLowerCase().includes(query)
        );

        // Tampilkan hasil pencarian
        filteredPasien.forEach(p => {
            const option = document.createElement('a');
            option.classList.add('list-group-item', 'list-group-item-action');
            option.style.cursor = 'pointer';
            option.textContent = `${p.no_bpjs} - ${p.nama}`;
            option.addEventListener('click', function() {
                searchInput.value = `${p.no_bpjs} - ${p.nama}`;
                document.getElementById('no_bpjs').value = p.no_bpjs;
                document.getElementById('nama_input').value = p.nama;
                document.getElementById('alamat_input').value = p.alamat;
                document.getElementById('jk_input').value = p.jenis_kelamin;
                document.getElementById('tgl_lahir').value = p.tanggal_lahir;
                document.getElementById('no_telepon').value = p.no_telepon;
                document.getElementById('keterangan').value = p.keterangan;
                listPasienDiv.innerHTML = '';
                listContainer.innerHTML = '';
            });

            listPasienDiv.appendChild(option);
        });
    });

    // Klik luar suggestion -> tutup list
    document.addEventListener('click', function(e) {
        if (!listPasienDiv.contains(e.target) && e.target !== searchInput) {
            listPasienDiv.innerHTML = '';
        }
    });

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

    // AUTO BUKA submenu kalau URL mengandung /hasillab atau /jadwalkunjungan
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

