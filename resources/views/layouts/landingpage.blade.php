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
    .btn-primary{
        background-color: rgba(0,107,176,1) 100%;
    }

    .modal {
    z-index: 1050;
}

.modal-backdrop {
    z-index: 1040;
}
</style>
<body>
    @php
        $settingInformasi = App\Models\SettingInformasi::first();
    @endphp
    <header style="background: rgb(0,157,217);
background: linear-gradient(21deg, rgba(0,157,217,1) 0%, rgba(0,107,176,1) 100%);">
        <div class="container p-2 text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <div class="d-flex gap-1">
                        <i class="fa-solid fa-envelope"></i>
                        <a href="mailto:{{ $settingInformasi->email }}" target="_blank" class="text-white text-decoration-none" style="font-size: 12px">{{ $settingInformasi->email }}</a>
                    </div>
                    <div class="d-flex gap-1">
                        <i class="fa-solid fa-phone"></i>
                        <a href="https://wa.me/{{ $settingInformasi->no_telepon }}" target="_blank"  class="text-white text-decoration-none" style="font-size: 12px">{{ $settingInformasi->no_telepon }}</a>
                    </div>
                </div>
                

                <span class="m-0">{{ $settingInformasi->alamat }}</span>
            </div>
        </div>
    </header>
    <nav class="navbar container mt-4 navbar-expand-lg navbar-light bg-light shadow rounded-5 sticky-top" style="border:1px solid rgb(0, 110, 255)">
        <div class="container">
            <img src="{{ asset('storage/' . $settingInformasi->logo) }}" width="50" alt="Logo">
            <a class="navbar-brand mx-2" href="#">{{ $settingInformasi->nama_perusahaan }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang-kami">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('daftarKendaraan') }}">Daftar Mobil dan Motor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/semua-wisata">Kontak</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @if (Route::has('login'))
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png" alt="Profile Image"
                                    class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                <span class="ms-2">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('sewa.riwayat') }}">Riwayat</a></li>
                                <li><a class="dropdown-item" href="{{ route('wisatawan.profile.index') }}">Setting Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('editPassword') }}">Update Password</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-primary rounded-5 px-4 mx-2 py-2" data-bs-toggle="modal"
                                data-bs-target="#loginModal">Login</a>
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
    
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    @yield('content')


    <!-- resources/views/components/footer.blade.php -->
    <footer class="bg-light text-center text-lg-start mt-auto">
        {{-- <div class="container p-4">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Company Name</h5>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                    Vestibulum in neque et nisl.
                </p>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Links</h5>
                <ul class="list-unstyled mb-0">
                    <li>
                        <a href="#!" class="text-dark">Link 1</a>
                    </li>
                    <li>
                        <a href="#!" class="text-dark">Link 2</a>
                    </li>
                    <li>
                        <a href="#!" class="text-dark">Link 3</a>
                    </li>
                    <li>
                        <a href="#!" class="text-dark">Link 4</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Contact</h5>
                <ul class="list-unstyled mb-0">
                    <li>
                        <a href="tel:+1234567890" class="text-dark">+1 234 567 890</a>
                    </li>
                    <li>
                        <a href="mailto:info@example.com" class="text-dark">info@example.com</a>
                    </li>
                    <li>
                        <a href="#!" class="text-dark">Address Line 1</a>
                    </li>
                    <li>
                        <a href="#!" class="text-dark">Address Line 2</a>
                    </li>
                </ul>
            </div>
        </div>
    </div> --}}
        <div class="text-center p-3 bg-dark text-white">
            © 2024 Company Name. All rights reserved.
        </div>
    </footer>


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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
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
