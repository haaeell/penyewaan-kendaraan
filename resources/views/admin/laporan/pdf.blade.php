<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Laporan Pemesanan</h1>
    <p>Bulan: {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}</p>
    <p>Total Pendapatan: Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</p>

    <table>
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
                    <td>Rp. {{ number_format($sewa->total_harga, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($sewa->status) }}</td>
                    <td>{{ $sewa->jenisPembayaran->nama }} - No Rek: {{ $sewa->jenisPembayaran->no_rek }}</td>
                    <td>{{ ucfirst($sewa->metode_pickup) }}</td>
                    <td>
                        @if($sewa->metode_pickup == 'diantar' && $sewa->lokasi_pickup)
                            @php
                                $lokasi = str_replace('Lat: ', '', str_replace('Lng: ', '', $sewa->lokasi_pickup));
                            @endphp
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $lokasi }}" target="_blank">Lihat Lokasi</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
