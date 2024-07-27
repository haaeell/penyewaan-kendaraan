@extends('layouts.landingpage')

@section('content')
   {{-- HERO SECTION --}}
   <section>
    <div class="container bg-white my-5 rounded-4 p-4">
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.pexels.com/photos/5229602/pexels-photo-5229602.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                         class="d-block w-100"
                         style="height: 70vh; object-fit: cover; border-radius: 4px;"
                         alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>First slide label</h5>
                        <p>Some representative placeholder content for the first slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.pexels.com/photos/2120/city-traffic-people-smartphone.jpg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                         class="d-block w-100"
                         style="height: 70vh; object-fit: cover; border-radius: 4px;"
                         alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Some representative placeholder content for the second slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.pexels.com/photos/995232/pexels-photo-995232.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                         class="d-block w-100"
                         style="height: 70vh; object-fit: cover; border-radius: 4px;"
                         alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Third slide label</h5>
                        <p>Some representative placeholder content for the third slide.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
       </div>
   </section>

   {{-- TENTANG KAMI --}}
   <section id="tentang-kami">
    <div class=" bg-white my-5 p-5 rounded-4">
        <h3 class="fw-bold text-center">
            TENTANG KAMI
        </h3>
        <div class="row my-5  justify-content-center gap-5 text-center">
            <div class="col-md-3">
                <h5 class="fw-bold ">Lorem, ipsum.</h5>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa eveniet repellendus inventore, nulla eligendi voluptas! </p>
            </div>
            <div class="col-md-3">
                <h5 class="fw-bold ">Lorem, ipsum.</h5>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa eveniet repellendus inventore, nulla eligendi voluptas! </p>
            </div>
            <div class="col-md-3">
                <h5 class="fw-bold ">Lorem, ipsum.</h5>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa eveniet repellendus inventore, nulla eligendi voluptas! </p>
            </div>
        </div>
    </div>
   </section>

{{-- FAQS --}}
<section id="faqs" class="container my-5">
    <h3 class="text-center mb-4 fw-bold">Frequently Asked Questions (FAQs)</h3>
    <div class="accordion" id="faqAccordion">
        <!-- FAQ Item 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Apa syarat untuk menyewa mobil atau motor?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Untuk menyewa mobil atau motor, Anda perlu menyediakan KTP, SIM yang sesuai, dan kartu kredit sebagai jaminan. Kami juga memerlukan deposit yang bervariasi tergantung pada jenis kendaraan.
                </div>
            </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Apakah ada batasan jarak tempuh untuk penyewaan?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Batasan jarak tempuh bisa bervariasi tergantung pada paket penyewaan yang Anda pilih. Beberapa paket menyediakan batas jarak harian, dan ada juga paket tanpa batasan jarak. Pastikan untuk memeriksa ketentuan pada saat pemesanan.
                </div>
            </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Bagaimana jika terjadi kerusakan pada kendaraan selama penyewaan?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Jika terjadi kerusakan pada kendaraan, segera hubungi layanan pelanggan kami. Kami akan memberikan petunjuk tentang langkah selanjutnya dan bagaimana melaporkan kerusakan. Biaya perbaikan mungkin dikenakan jika kerusakan disebabkan oleh kelalaian atau pelanggaran peraturan.
                </div>
            </div>
        </div>

        <!-- FAQ Item 4 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Apakah saya bisa mengubah atau membatalkan pemesanan?
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Ya, Anda bisa mengubah atau membatalkan pemesanan dengan memberi tahu kami dalam jangka waktu tertentu sesuai dengan kebijakan pembatalan. Pastikan untuk memeriksa syarat dan ketentuan kami untuk detail lebih lanjut.
                </div>
            </div>
        </div>

        <!-- FAQ Item 5 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    Apakah ada asuransi yang disediakan untuk kendaraan sewaan?
                </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Ya, semua kendaraan sewaan kami dilengkapi dengan asuransi dasar. Namun, kami juga menawarkan opsi asuransi tambahan untuk perlindungan lebih lanjut. Silakan hubungi kami untuk informasi lebih lanjut mengenai pilihan asuransi yang tersedia.
                </div>
            </div>
        </div>

        <!-- FAQ Item 6 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingSix">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    Bagaimana cara mengembalikan kendaraan?
                </button>
            </h2>
            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Anda dapat mengembalikan kendaraan ke lokasi yang telah disepakati sebelumnya pada saat pemesanan. Pastikan untuk mengembalikan kendaraan dalam kondisi yang sama seperti saat diterima. Kami juga menyediakan layanan pengambilan kendaraan di lokasi tertentu dengan biaya tambahan.
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Hubungi kami --}}
<section id="hubungi-kami" class="container my-5">
   <div class="container bg-white rounded-4 p-4">
    <h2 class="text-center mb-4">Hubungi Kami</h2>
    <div class="row">
        <div class="col-md-6">
            <h4>Informasi Kontak</h4>
            <p><strong>Alamat:</strong> Jl. Contoh Alamat No. 123, Kota, Negara</p>
            <p><strong>Telepon:</strong> (012) 345-6789</p>
            <p><strong>Email:</strong> info@example.com</p>
            <p><strong>Jam Operasional:</strong> Senin - Jumat, 09:00 - 17:00</p>
        </div>
    </div>
   </div>
</section>

@endsection
