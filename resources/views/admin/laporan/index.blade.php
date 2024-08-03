@extends('layouts.dashboard')

@section('title', 'Laporan Pemesanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow border-0">
            <div class="card-body">
                <!-- Form Filter -->
                <form action="{{ route('laporan.index') }}" method="GET" class="mb-4" id="filterForm">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="bulan">Filter Bulan:</label>
                            <select name="bulan" id="bulan" class="form-control" onchange="this.form.submit()">
                                <option value="">Pilih Bulan</option>
                                @foreach ([
                                    1 => 'Januari', 
                                    2 => 'Februari', 
                                    3 => 'Maret', 
                                    4 => 'April', 
                                    5 => 'Mei', 
                                    6 => 'Juni', 
                                    7 => 'Juli', 
                                    8 => 'Agustus', 
                                    9 => 'September', 
                                    10 => 'Oktober', 
                                    11 => 'November', 
                                    12 => 'Desember'] as $num => $name)
                                    <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tahun">Tahun:</label>
                            <input type="number" name="tahun" id="tahun" class="form-control" value="{{ $tahun }}" onchange="this.form.submit()">
                        </div>
                    </div>
                </form>

                <div class="mb-4">
                    <h5>Total Pendapatan Bulan Ini: Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</h5>
                    <a href="{{ route('laporan.cetakPDF', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-danger text-white " target="_blank">Cetak PDF</a>
                </div>

                <div class="table-responsive">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Wisatawan</th>
                                <th>Nama Kendaraan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Jenis Pembayaran</th>
                                <th>Metode Pickup</th>
                                <th>Lokasi Pickup</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan as $sewa)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sewa->wisatawan->nama }}</td>
                                    <td>{{ $sewa->kendaraan->nama }}</td>
                                    <td>{{ $sewa->tanggal_mulai }}</td>
                                    <td>{{ $sewa->tanggal_selesai }}</td>
                                    <td>
                                        @if ($sewa->harga_setelah_diskon)
                                            Rp {{ number_format($sewa->harga_setelah_diskon, 0, ',', '.') }}
                                        @else
                                            Rp {{ number_format($sewa->total_harga, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td>{{ ucfirst($sewa->status) }}</td>
                                    <td>{{ $sewa->jenisPembayaran->nama }} - No Rek: {{ $sewa->jenisPembayaran->no_rek }}</td>
                                    <td>{{ ucfirst($sewa->metode_pickup) }}</td>
                                    <td>
                                        @if($sewa->metode_pickup == 'diantar' && $sewa->lokasi_pickup)
                                            @php
                                                $lokasi = str_replace('Lat: ', '', str_replace('Lng: ', '', $sewa->lokasi_pickup));
                                            @endphp
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $lokasi }}" target="_blank" class="btn btn-info btn-sm text-white">Lihat Lokasi</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Automatically submit the form when the month or year is changed
    document.getElementById('bulan').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
    document.getElementById('tahun').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
</script>
@endsection
