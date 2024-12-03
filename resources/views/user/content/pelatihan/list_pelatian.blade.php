<div class="container mt-5">
    <!-- Available Pelatihan Slider (Main Slider) -->
    <h2 class="my-4">Pelatihan yang Tersedia</h2>
    <div class="swiper slide-container">
        <div class="swiper-wrapper">
            @forelse($pelatihans as $pelatihan)
                <div class="swiper-slide">
                    <div class="card h-100 border-0 rounded-3 fixed-card-size">
                        <div class="position-relative overflow-hidden">
                            <img src="{{ asset('img/pelatihan/' . ($pelatihan->gambar ?? 'default.jpg')) }}"
                                class="card-img-top rounded-top" alt="{{ $pelatihan->nama }}">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $pelatihan->nama }}</h5>
                            <p class="card-text text-success fw-bold fs-5 mb-2"><strong>Harga:</strong> Rp.
                                {{ number_format($pelatihan->harga, 0, ',', '.') }}</p>
                            <p class="card-text description">{{ Str::limit($pelatihan->deskripsi, 300) }}</p>
                            <div class="card-footer fixed-footer bg-white">
                                <a href="{{ route('user.pelatihan.deskripsi', $pelatihan->id) }}"
                                    class="btn btn-primary btn-sm px-4 rounded-pill w-100">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">Tidak ada pelatihan yang tersedia.</p>
            @endforelse
        </div>

        <!-- Swiper Navigation -->
        <div class="swiper-button-next swiper-navBtn"></div>
        <div class="swiper-button-prev swiper-navBtn"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Kategori Pelatihan with Slider -->
    <h2 class="my-4">Kategori Pelatihan</h2>
    @foreach ($kategoris as $kategori)
        <div class="category-section mb-5">
            <h4>{{ $kategori->nama }}</h4>
            <div class="swiper category-swiper">
                <div class="swiper-wrapper">
                    @foreach ($kategori->pelatihan as $pelatihan)
                        <div class="swiper-slide">
                            <div class="card h-100 border-0 rounded-3 fixed-card-size m-3">
                                <div class="position-relative">
                                    <img src="{{ asset('img/pelatihan/' . ($pelatihan->gambar ?? 'default.jpg')) }}"
                                        class="card-img-top rounded-top" alt="{{ $pelatihan->nama }}">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $pelatihan->nama }}</h5>
                                    <p class="card-text text-success fw-bold fs-5 mb-2"><strong>Harga:</strong> Rp.
                                        {{ number_format($pelatihan->harga, 0, ',', '.') }}</p>
                                    <p class="card-text description">{{ Str::limit($pelatihan->deskripsi, 300) }}</p>
                                    <div class="card-footer fixed-footer bg-white">
                                        <a href="{{ route('user.pelatihan.deskripsi', $pelatihan->id) }}"
                                            class="btn btn-primary btn-sm px-4 rounded-pill w-100">
                                            Lihat Detail
                                        </a>
                                    </div>
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
    var mainSwiper = new Swiper(".slide-container", {
        slidesPerView: 4, // Menampilkan 4 kartu
        spaceBetween: 20, // Jarak antar kartu
        loop: true, // Looping slider
        autoplay: {
            delay: 3000, // Delay antar slide
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination", // Pagination dots
            clickable: true, // Bisa diklik
            dynamicBullets: true, // Bullets dinamis
        },
        navigation: {
            nextEl: ".swiper-button-next", // Tombol next
            prevEl: ".swiper-button-prev", // Tombol prev
        },
        breakpoints: {
            0: {
                slidesPerView: 1
            },
            520: {
                slidesPerView: 2
            },
            950: {
                slidesPerView: 3
            },
            1200: {
                slidesPerView: 4
            }, // Sesuaikan untuk layar besar
        },
    });

    // Category-wise Swipers
    var categorySwipers = document.querySelectorAll('.category-swiper');
    categorySwipers.forEach(function(categorySwiper) {
        new Swiper(categorySwiper, {
            slidesPerView: 4, // Menampilkan 4 kartu
            spaceBetween: 20, // Jarak antar kartu
            loop: true, // Looping slider
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
                0: {
                    slidesPerView: 1
                },
                520: {
                    slidesPerView: 2
                },
                950: {
                    slidesPerView: 3
                },
                1200: {
                    slidesPerView: 4
                }, // Sesuaikan untuk layar besar
            },
        });
    });
</script>
<style>
    /* Fixed card size to perfect square */
.fixed-card-size {
    width: 250px;
    height: 250px; /* Make it a square */
    display: flex;
    flex-direction: column;
    border: 2px solid black; /* Add black outline */
    border-radius: 0; /* Remove rounded corners */
}

/* Ensure the image fits perfectly in the square card */
.card-img-top {
    height: 150px; /* Adjust image height */
    object-fit: cover; /* Ensure it fills the area */
    border-bottom: 2px solid black; /* Outline between image and body */
}

/* Card body adjustments */
.card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 10px; /* Add padding for content */
}

/* Restrict the description overflow */
.description {
    height: 40px; /* Adjust for new size */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Swiper navigation buttons */
.swiper-button-next,
.swiper-button-prev {
    color: #000; /* Black buttons for better contrast */
    font-size: 24px;
    z-index: 10;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    color: #333;
    opacity: 0.8;
}

/* Smooth transition for cards */
.swiper-slide {
    transition: transform 0.3s ease-in-out;
}

</style>
