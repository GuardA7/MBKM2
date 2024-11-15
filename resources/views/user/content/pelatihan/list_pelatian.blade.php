
<div class="container">
    <!-- Available Pelatihan Slider (Main Slider) -->
    <h2 class="my-4">Pelatihan yang Tersedia</h2>
    <div class="slide-container swiper">
        <div class="slide-content">
            <div class="card-wrapper swiper-wrapper">
                @forelse($pelatihans as $pelatihan)
                <div class="swiper-slide">
                    <div class="card h-100 shadow-sm border-0 fixed-card-size">
                        <div class="position-relative">
                            <img src="{{ asset('img/pelatihan/' . ($pelatihan->gambar ?? 'default.jpg')) }}" class="card-img-top rounded-top" alt="{{ $pelatihan->nama }}">
                        </div>
                        <div class="card-body d-flex flex-column text-center">
                            <h5 class="card-title">{{ $pelatihan->nama }}</h5>
                            <p class="card-text description">{{ Str::limit($pelatihan->deskripsi, 100) }}</p>
                            <p class="card-text"><strong>Harga:</strong> Rp. {{ number_format($pelatihan->harga, 0, ',', '.') }}</p>
                            <p class="card-text"><strong>Kuota:</strong> {{ $pelatihan->kuota }}</p>
                            <a href="{{ route('user.pelatihan.deskripsi', $pelatihan->id) }}" class="btn btn-primary mt-auto">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-center">Tidak ada pelatihan yang tersedia.</p>
                @endforelse
            </div>
        </div>

        <!-- Swiper Navigation -->
        <div class="swiper-button-next swiper-navBtn"></div>
        <div class="swiper-button-prev swiper-navBtn"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Kategori Pelatihan with Slider -->
    <h2 class="my-4">Kategori Pelatihan</h2>
    @foreach($kategoris as $kategori)
    <div class="category-section mb-5">
        <h4>{{ $kategori->nama }}</h4>
        <div class="swiper category-swiper">
            <div class="swiper-wrapper">
                @foreach($kategori->pelatihan as $pelatihan)
                <div class="swiper-slide">
                    <div class="card h-100 shadow-sm border-0 fixed-card-size">
                        <div class="position-relative">
                            <img src="{{ asset('img/pelatihan/' . ($pelatihan->gambar ?? 'default.jpg')) }}" class="card-img-top rounded-top" alt="{{ $pelatihan->nama }}">
                        </div>
                        <div class="card-body d-flex flex-column text-center">
                            <h5 class="card-title">{{ $pelatihan->nama }}</h5>
                            <p class="card-text description">{{ Str::limit($pelatihan->deskripsi, 100) }}</p>
                            <p class="card-text"><strong>Harga:</strong> Rp. {{ number_format($pelatihan->harga, 0, ',', '.') }}</p>
                            <p class="card-text"><strong>Kuota:</strong> {{ $pelatihan->kuota }}</p>
                            <a href="{{ route('user.pelatihan.deskripsi', $pelatihan->id) }}" class="btn btn-primary mt-auto">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Swiper Navigation for Category -->
            <div class="swiper-button-next swiper-navBtn"></div>
            <div class="swiper-button-prev swiper-navBtn"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    @endforeach
</div>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Swiper Initialization Script -->
<script>
    // Main Swiper (for available pelatihan)
    var mainSwiper = new Swiper(".slide-content", {
        slidesPerView: 3,
        spaceBetween: 25,
        loop: true,
        centerSlide: 'true',
        grabCursor: 'true',
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: { slidesPerView: 1 },
            520: { slidesPerView: 2 },
            950: { slidesPerView: 3 },
        },
    });

    // Category-wise Swipers
    var categorySwipers = document.querySelectorAll('.category-swiper');
    categorySwipers.forEach(function (categorySwiper) {
        new Swiper(categorySwiper, {
            slidesPerView: 3,
            spaceBetween: 25,
            loop: true,
            pagination: {
                el: categorySwiper.querySelector('.swiper-pagination'),
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: categorySwiper.querySelector('.swiper-button-next'),
                prevEl: categorySwiper.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                0: { slidesPerView: 1 },
                520: { slidesPerView: 2 },
                950: { slidesPerView: 3 },
            },
        });
    });
</script>

<style>
    /* Ensures fixed card size */
    .fixed-card-size {
        width: 300px; /* Fixed width */
        height: 450px; /* Fixed height */
        display: flex;
        flex-direction: column;
    }

    /* Ensures the image fills its section without stretching */
    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    /* Set a fixed height for card body to ensure text fits */
    .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* Controls text overflow */
    .description {
        height: 60px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

