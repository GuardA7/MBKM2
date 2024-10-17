@extends('user.layouts.app')

@section('content')
    <main>
        <div class="hero-image position-relative">
            <img src="{{ asset('user/img/DSC_5537-1320x600.jpg') }}" alt="Hero Image" class="w-100">
            <div class="wave position-absolute bottom-0 w-100">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <defs>
                        <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#FFFFFF; stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#f8f9fa; stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#gradient)" fill-opacity="1"
                        d="M0,128L48,133.3C96,139,192,149,288,149.3C384,149,480,139,576,144C672,149,768,171,864,186.7C960,203,1056,213,1152,208C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </div>
        </div>

        <div class="container-fluid px-4 content-container bg-light py-5">
            <h2 class="category-title text-center mb-5">Search Pelatihan</h2>
            <form class="d-flex justify-content-center mb-4">
                <input type="text" class="form-control me-2 shadow-sm" placeholder="Cari Kategori..." aria-label="Search">
                <button class="btn btn-primary px-4 shadow-sm" type="submit">Cari</button>
            </form>

            <div class="row mb-3 mt-5">
                <div class="col Title-Pelatihan">
                    <h2>Daftar Pelatihan</h2>
                </div>
                <div class="col d-flex justify-content-end align-items-center">
                    <a href="#" class="text-primary fw-bold text-decoration-none">Lihat Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="row justify-content-center">
                <!-- Card 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 rounded-lg hover-shadow">
                        <img src="https://th.bing.com/th?id=OIP.jk30kT5eZ77WiN3HHWhYFwAAAA&w=306&h=203&c=8&rs=1&qlt=90&o=6&dpr=1.5&pid=3.1&rm=2"
                            class="card-img-top rounded-top" alt="Course Title">
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-2 fw-bold">Judul Pelatihan 1</h5>
                            <p class="text-muted"><strong>Harga: </strong>500.000 IDR</p>
                            <hr>
                            <p class="card-text text-muted">Pelajari lebih lanjut dan tingkatkan keterampilan Anda dengan pelatihan ini.</p>
                            <hr>
                            <p class="text-muted"><strong>Jadwal: </strong>15 Oktober 2024, 10:00 - 14:00 WIB</p>
                            <a href="#" class="btn btn-primary w-100 mt-3">Join Pelatihan</a>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 rounded-lg hover-shadow">
                        <img src="https://th.bing.com/th?id=OIP.jk30kT5eZ77WiN3HHWhYFwAAAA&w=306&h=203&c=8&rs=1&qlt=90&o=6&dpr=1.5&pid=3.1&rm=2"
                            class="card-img-top rounded-top" alt="Course Title">
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-2 fw-bold">Judul Pelatihan 2</h5>
                            <p class="text-muted"><strong>Harga: </strong>700.000 IDR</p>
                            <hr>
                            <p class="card-text text-muted">Tingkatkan keterampilan Anda dengan materi mendalam dari pelatihan ini.</p>
                            <hr>
                            <p class="text-muted"><strong>Jadwal: </strong>20 Oktober 2024, 09:00 - 13:00 WIB</p>
                            <a href="#" class="btn btn-primary w-100 mt-3">Join Pelatihan</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 rounded-lg hover-shadow">
                        <img src="https://th.bing.com/th?id=OIP.jk30kT5eZ77WiN3HHWhYFwAAAA&w=306&h=203&c=8&rs=1&qlt=90&o=6&dpr=1.5&pid=3.1&rm=2"
                            class="card-img-top rounded-top" alt="Course Title">
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title mb-2 fw-bold">Judul Pelatihan 3</h5>
                            <p class="text-muted"><strong>Harga: </strong>800.000 IDR</p>
                            <hr>
                            <p class="card-text text-muted">Kuasai keterampilan baru dengan pelatihan interaktif ini.</p>
                            <hr>
                            <p class="text-muted"><strong>Jadwal: </strong>25 Oktober 2024, 13:00 - 17:00 WIB</p>
                            <a href="#" class="btn btn-primary w-100 mt-3">Join Pelatihan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
