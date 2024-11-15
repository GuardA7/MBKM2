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
            @include('user.content.pelatihan.list_pelatian')


    </main>
@endsection
