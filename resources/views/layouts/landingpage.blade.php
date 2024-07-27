<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<style>
    .btn-primary {
        background-color: #f0b71b;
        border: 1px solid #f0b71b;
    }

    .btn-primary:hover {
        background-color: #d69404;
        border: 1px solid #d69404;
    }
</style>

<body style="background-color: rgb(228, 228, 231)">
    <nav class="navbar navbar-expand-lg bg-warning p-4">
        <div class="container">
            <img src="https://api.bbksdajatim.org/tiket-api/upload/lokasi/2024-03-29/file/MIB9eY128h.png" width="70"
                alt="">
            <a class="navbar-brand fw-bold text-white" href="#">SEWA MOTOR24 JOGJA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mx-5 gap-3 ">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold active" aria-current="page" href="/">
                            <div class="d-flex align-items-center text-white">
                                <div class="icon-container">
                                    <i class="fa-solid fa-envelope fa-2x"></i>
                                </div>
                                <div class="text-container ms-2">
                                    <p class="mb-0">FOR SUPPORT MAIL US</p>
                                    <p class="mb-0" style="font-size: 12px">Sewamotorjogja24@gmail.com</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold active" aria-current="page" href="/">
                            <div class="d-flex align-items-center text-white">
                                <div class="icon-container">
                                    <i class="fa-solid fa-phone fa-2x"></i>
                                </div>
                                <div class="text-container ms-2">
                                    <p class="mb-0">FOR SERVICES CALL US</p>
                                    <p class="mb-0" style="font-size: 12px">09865446787</p>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <nav class="navbar navbar-expand-lg bg-white p-3 ">
        <div class="container">
            <ul class="navbar-nav mx-auto mx-5 gap-3">
                <li class="nav-item">
                    <a class="nav-link fw-semibold active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="#tentang-kami">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ route('daftarKendaraan') }}">Daftar Mobil dan Motor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="/semua-wisata">FAQS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="/semua-wisata">HUBUNGI KAMI</a>
                </li>

            </ul>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <!-- Navbar Profile Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                    id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <!-- Display user image and name -->
                                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png"
                                        alt="Profile Image" class="rounded-circle"
                                        style="width: 40px; height: 40px; object-fit: cover;">
                                    <span class="ms-2">{{ auth()->user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('sewa.riwayat') }}">Riwayat</a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-primary rounded-2 px-4 mx-2 py-2" href="{{ route('login') }}">Login</a>
                            </li>

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/register') }}">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>


    @yield('content')


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @yield('script')

    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            scrollbar: {
                el: '.swiper-scrollbar',
            },
            pagination: {
                el: '.swiper-pagination',
            },
        });
    </script>

    <script>
        var swiperCard = new Swiper(".swiperCard", {
            slidesPerView: 3,
            spaceBetween: 30,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>
    @if ($errors->any())
        <script>
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += "{{ $error }}\n";
            @endforeach

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMessages,
            });
        </script>
    @endif

    @if (session('success') || session('error'))
        <script>
            $(document).ready(function() {
                var successMessage = "{{ session('success') }}";
                var errorMessage = "{{ session('error') }}";

                if (successMessage) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: successMessage,
                    });
                }

                if (errorMessage) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                    });
                }
            });
        </script>
    @endif


</body>

</html>
