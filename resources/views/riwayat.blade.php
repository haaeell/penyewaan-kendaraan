@extends('layouts.landingpage')

@section('content')
<div class="container mt-5 min-vh-100">
    <div class="card shadow border-0 py-5 min-vh-100 rounded-4">
        <div class="card-body">
            <h4 class="mb-5 text-center fw-semibold">Riwayat Pemesanan</h4>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Sewa</th>
                            <th>Nama Kendaraan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Total Harga</th>
                            <th>Jenis Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sewa as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->kode_sewa }}</td>
                                <td>{{ $item->kendaraan->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y h:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y h:i') }}</td>
                                <td>
                                    @if ($item->harga_setelah_diskon)
                                        Rp {{ number_format($item->harga_setelah_diskon, 0, ',', '.') }}
                                    @else
                                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                    @endif
                                </td>
                                
                                <td>{{ $item->jenisPembayaran->nama }} - No rek: {{ $item->jenisPembayaran->no_rek }}</td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'belum_dibayar' => 'bg-warning text-dark',
                                            'menunggu_konfirmasi' => 'bg-info text-white',
                                            'sedang_diproses' => 'bg-primary text-white',
                                            'diterima' => 'bg-success text-white',
                                            'selesai' => 'bg-secondary text-white',
                                            'dibatalkan' => 'bg-danger text-white',
                                        ];
                                        $statusClass = $statusClasses[$item->status] ?? 'bg-secondary text-white';
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($item->status == 'belum_dibayar')
                                        <form action="{{ route('sewa.uploadBukti', $item) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="file" class="form-control" name="bukti_pembayaran" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Upload Bukti Pembayaran</button>
                                        </form>
                                    @endif

                                    @if ($item->status == 'diterima')
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#extendRentalModal{{ $item->id }}">
                                            Perpanjang Sewa
                                        </button>
                            
                                        <!-- Modal Perpanjangan Sewa -->
                                        <div class="modal fade" id="extendRentalModal{{ $item->id }}" tabindex="-1" aria-labelledby="extendRentalModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="extendRentalModalLabel{{ $item->id }}">Perpanjang Sewa - Kode Sewa: {{ $item->kode_sewa }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('sewa.perpanjang', $item->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="tanggal_selesai_baru" class="form-label">Tanggal Selesai Baru</label>
                                                                <input type="date" class="form-control" id="tanggal_selesai_baru" name="tanggal_selesai_baru" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="bukti_pembayaran_tambahan" class="form-label">Bukti Pembayaran Tambahan</label>
                                                                <input type="file" class="form-control" id="bukti_pembayaran_tambahan" name="bukti_pembayaran_tambahan" required>
                                                            </div>
                                                            <p><strong>Total Harga Tambahan: </strong><span id="harga_tambahan_{{ $item->id }}"></span></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-info text-white">Perpanjang Sewa</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada riwayat pemesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach ($sewa as $item)
            document.getElementById('tanggal_selesai_baru').addEventListener('change', function() {
                const tanggalSelesaiAsli = new Date('{{ $item->tanggal_selesai }}');
                const tanggalSelesaiBaru = new Date(this.value);
                const hargaPerHari = {{ $item->kendaraan->harga }};
                
                if (tanggalSelesaiBaru > tanggalSelesaiAsli) {
                    const durasiTambahan = Math.ceil((tanggalSelesaiBaru - tanggalSelesaiAsli) / (1000 * 60 * 60 * 24));
                    const totalHargaTambahan = durasiTambahan * hargaPerHari;
                    document.getElementById('harga_tambahan_{{ $item->id }}').innerText = 'Rp ' + totalHargaTambahan.toLocaleString('id-ID');
                } else {
                    document.getElementById('harga_tambahan_{{ $item->id }}').innerText = 'Rp 0';
                }
            });
        @endforeach
    });
</script>

@endsection
