@extends('layouts.landingpage')

@section('content')
<div class="container mt-5 min-vh-100">
    <div class="card shadow border-0 py-5min-vh-100 rounded-4">
        <div class="card-body">
            <h4 class="mb-4 text-center fw-semibold">Riwayat Pemesanan</h4>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Sewa</th>
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
                            <td>{{ $item->tanggal_mulai }}</td>
                            <td>{{ $item->tanggal_selesai }}</td>
                            <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td>{{ $item->jenisPembayaran->nama }} - No rek: {{ $item->jenisPembayaran->no_rek }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $item->status)) }}</td>
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
@endsection
