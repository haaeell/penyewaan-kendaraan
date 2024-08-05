@extends('layouts.landingpage')

@section('content')
<style>
.card-img {
    transition: transform 0.3s ease;
}

.card-kendaraan:hover .card-img {
    transform: scale(1.1); 
    object-fit: cover;
}
</style>
    {{-- HERO SECTION --}}
    <section>
        <div class="container bg-white my-5 rounded-4 p-4">
            <div id="carouselExampleCaptions" class="carousel slide">
                <div class="carousel-indicators">
                    @foreach ($promo as $key => $item)
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $key }}"
                            class="{{ $key === 0 ? 'active' : '' }}" aria-current="{{ $key === 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $key + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach ($promo as $key => $item)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="d-block w-100"
                                style="height: 70vh; object-fit: cover; border-radius: 4px;" alt="Promo Image">
                            <div class="carousel-caption d-none d-md-block text-dark">
                                <div class="card shadow border-0 rounded-4">
                                    <div class="card-body">
                                        <h5 class="fw-bold text-uppercase">{{ $item->deskripsi }}</h5>
                                        <p class="m-0 fw-semibold">Kode Promo: <span class="text-danger text-underline">
                                                {{ $item->kode }}</span></p>
                                        <p class="m-0 ">Mulai dari tanggal
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d F Y') }} -
                                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>



    {{-- TENTANG KAMI --}}
    <section id="tentang-kami">
        <div class="container bg-white my-5 p-5 rounded-4">
            <h3 class="fw-bold text-center">
                Tentang Kami
            </h3>
            <div class="row my-5 justify-content-center ">
                <div class="col-md-4 text-center mb-5">
                    <img src="https://imgcdn.oto.com/large/gallery/exterior/73/2270/honda-beat-esp-slant-rear-view-full-image-226189.jpg"
                        alt=""  class="rounded-circle shadow" style="width: 200px; height: 200px; object-fit:cover;">
                </div>
                <div class="col-md-12 text-center">
                    <h1 class="fw-bold text-dark">
                        Selamat Datang di Rental Motor Jogja
                    </h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sit, velit soluta, quibusdam illo, repellat
                        ea alias sequi deserunt quia reiciendis quidem! Est culpa deleniti maxime optio nesciunt? Sunt modi
                        necessitatibus velit culpa esse labore ipsum molestiae atque vitae debitis. Vel eaque, odit rem
                        similique at quia magni accusantium nesciunt velit minima delectus in cum quibusdam. Delectus eos
                        quo, magni maiores soluta perferendis voluptates quod facilis minus optio harum at minima? Placeat
                        sit eius eum officiis quam, debitis, optio, ipsam sed fugit magnam aut hic nam esse? Sit maiores
                        quasi adipisci suscipit earum a, dolorem qui repudiandae distinctio numquam beatae saepe.</p>
                    {{-- <a href="" class="btn btn-outline-primary rounded-5 px-4 mt-4"> Lihat Detail <i
                            class="fas fa-arrow-right"></i></a> --}}
                </div>
               
            </div>
        </div>
    </section>

    {{-- DAFTAR KENDARAAN --}}
    <section>
        <div class="container">
            <h3 class="fw-bold text-center">
                Daftar Kendaraan
            </h3>
            <div class="row d-flex my-5">
                <a href="/daftarKendaraan" class="text-primary text-end mb-3 text-decoration-none fw-semibold">Lihat Semua
                    Kendaraan <i class="fas fa-arrow-alt-circle-right"></i></a>
                @foreach ($kendaraan as $item)
                    <div class="col-md-3 mb-4">
                        <div class="card  shadow border-light card-kendaraan">
                            <div class="card-body">
                                <img src="{{ asset('storage/' . $item->foto) }}" class="card-img" width="100%"
                                    style="height: 250px; object-fit:contain" />
                                <h4 class="fw-bold">{{ $item->nama }}</h4>
                                <hr>

                                <div class="bg-light p-2 w-full rounded-3 text-danger fw-bold fs-5">Rp
                                    {{ number_format($item->harga, 0, ',', '.') }}</div>
                                <div class="mt-3">
                                    @if (Auth::check())
                                        <a href="{{ route('sewa.create', ['kendaraan_id' => $item->id]) }}"
                                            class="btn btn-outline-primary w-full d-block">Pesan Sekarang</a>
                                    @else
                                        <a class="btn btn-outline-primary w-full d-block"
                                            data-bs-toggle="modal" data-bs-target="#loginModal">Pesan Sekarang</a>
                                    @endif
                                    <a href="{{ route('detailKendaraan', $item->id) }}"
                                        class="btn btn-primary w-full d-block mt-2 ">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    {{-- FAQS --}}
    <section id="faqs" class="container my-5">
        <h3 class="text-center my-5 fw-bold">Frequently Asked Questions (FAQs)</h3>
        <div class="accordion" id="faqAccordion">
            <!-- FAQ Item 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        Apa syarat untuk menyewa mobil atau motor?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Untuk menyewa mobil atau motor, Anda perlu menyediakan KTP, SIM yang sesuai, dan kartu kredit
                        sebagai jaminan. Kami juga memerlukan deposit yang bervariasi tergantung pada jenis kendaraan.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Apakah ada batasan jarak tempuh untuk penyewaan?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Batasan jarak tempuh bisa bervariasi tergantung pada paket penyewaan yang Anda pilih. Beberapa paket
                        menyediakan batas jarak harian, dan ada juga paket tanpa batasan jarak. Pastikan untuk memeriksa
                        ketentuan pada saat pemesanan.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Bagaimana jika terjadi kerusakan pada kendaraan selama penyewaan?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Jika terjadi kerusakan pada kendaraan, segera hubungi layanan pelanggan kami. Kami akan memberikan
                        petunjuk tentang langkah selanjutnya dan bagaimana melaporkan kerusakan. Biaya perbaikan mungkin
                        dikenakan jika kerusakan disebabkan oleh kelalaian atau pelanggaran peraturan.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Apakah saya bisa mengubah atau membatalkan pemesanan?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Ya, Anda bisa mengubah atau membatalkan pemesanan dengan memberi tahu kami dalam jangka waktu
                        tertentu sesuai dengan kebijakan pembatalan. Pastikan untuk memeriksa syarat dan ketentuan kami
                        untuk detail lebih lanjut.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        Apakah ada asuransi yang disediakan untuk kendaraan sewaan?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Ya, semua kendaraan sewaan kami dilengkapi dengan asuransi dasar. Namun, kami juga menawarkan opsi
                        asuransi tambahan untuk perlindungan lebih lanjut. Silakan hubungi kami untuk informasi lebih lanjut
                        mengenai pilihan asuransi yang tersedia.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        Bagaimana cara mengembalikan kendaraan?
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Anda dapat mengembalikan kendaraan ke lokasi yang telah disepakati sebelumnya pada saat pemesanan.
                        Pastikan untuk mengembalikan kendaraan dalam kondisi yang sama seperti saat diterima. Kami juga
                        menyediakan layanan pengambilan kendaraan di lokasi tertentu dengan biaya tambahan.
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Hubungi kami --}}
    @php
        $settingInformasi = App\Models\SettingInformasi::first();
    @endphp
    <section id="hubungi-kami" class="container my-5">
        <div class="container bg-white rounded-4 p-4">
            <h2 class="text-center fw-bold mb-4">Hubungi Kami</h2>
            <div class="row">
                <div class="col-md-12  p-5 rounded-5 text-white fw-semibold" style="background-color: rgb(1, 136, 177)">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-md-6">
                            <h4 class="fw-bold">Informasi Lebih Lanjut</h4>
                            <p>Jelajahi kota dengan gaya bersama Rental Motor. Temukan motor idamanmu dan pesan sekarang!</p>
                        </div>
                        <div class="col-md-6 ">
                            <div class="d-flex gap-3 align-items-center float-end">
                                <a href="https://api.whatsapp.com/send?phone={{$settingInformasi->no_telepon}}&text=Halo%20admin,%20saya%20ingin%20menyewa%20kendaraan" target="_blank" class="btn btn-outline-light px-2 py-3">
                                    <span>
                                        <i class="fas fa-phone fa-2xl mx-3"></i>{{ $settingInformasi->no_telepon }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
