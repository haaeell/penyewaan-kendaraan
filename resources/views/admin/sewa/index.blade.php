@extends('layouts.dashboard')

@section('title', 'Daftar Pemesanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Wisatawan</th>
                                <th>Nama Kendaraan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Total Harga</th>
                                <th>Jenis Pembayaran</th>
                                <th>Metode Pickup</th>
                                <th>Lokasi Pickup</th>
                                <th>Bukti Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sewas as $sewa)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sewa->wisatawan->nama }}</td>
                                    <td>{{ $sewa->kendaraan->nama }}</td>
                                    <td>{{ $sewa->tanggal_mulai }}</td>
                                    <td>{{ $sewa->tanggal_selesai }}</td>
                                    <td>
                                        @if($sewa->status == 'belum_dibayar')
                                            <span class="badge bg-secondary">{{ ucfirst($sewa->status) }}</span>
                                        @elseif($sewa->status == 'menunggu_konfirmasi')
                                            <span class="badge bg-warning">{{ ucfirst($sewa->status) }}</span>
                                        @elseif($sewa->status == 'sedang_diproses')
                                            <span class="badge bg-info">{{ ucfirst($sewa->status) }}</span>
                                        @elseif($sewa->status == 'diterima')
                                            <span class="badge bg-success">{{ ucfirst($sewa->status) }}</span>
                                        @elseif($sewa->status == 'selesai')
                                            <span class="badge bg-primary">{{ ucfirst($sewa->status) }}</span>
                                        @elseif($sewa->status == 'dibatalkan')
                                            <span class="badge bg-danger">{{ ucfirst($sewa->status) }}</span>
                                        @elseif($sewa->status == 'perpanjangan sewa')
                                            <span class="badge bg-danger">{{ ucfirst($sewa->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($sewa->harga_setelah_diskon)
                                            Rp {{ number_format($sewa->harga_setelah_diskon, 0, ',', '.') }}
                                        @else
                                            Rp {{ number_format($sewa->total_harga, 0, ',', '.') }}
                                        @endif
                                    </td>
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
                                    <td>
                                        @if($sewa->bukti_pembayaran)
                                            <a href="{{ asset('storage/' . $sewa->bukti_pembayaran) }}" target="_blank" class="btn btn-info btn-sm text-white">Lihat Bukti Pembayaran</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($sewa->status == 'menunggu_konfirmasi' )
                                        <div class="d-flex">
                                            <button class="btn btn-success text-white btn-sm" data-bs-toggle="modal" data-bs-target="#assignKaryawanModal-{{ $sewa->id }}">Setujui</button>
                                            <form action="{{ route('sewa.updateStatus', $sewa->id) }}" method="POST" style="display:inline-block; margin-left: 5px;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="tolak">
                                                <button type="submit" class="btn btn-danger text-white btn-sm">Tolak</button>
                                            </form>
                                        </div>
                                        @endif
                                        @if($sewa->status == 'perpanjangan sewa')
                                        <div class="d-flex">
                                            <form action="{{ route('sewa.updateStatus', $sewa->id) }}" method="POST" style="display:inline-block; margin-left: 5px;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="perpanjangan">
                                                <button type="submit" class="btn btn-danger text-white btn-sm">Tolak</button>
                                            </form>
                                        </div>
                                        @endif

                                        @if($sewa->status == 'sedang_diproses')
                                        <form action="{{ route('sewa.updateStatus', $sewa->id) }}" method="POST" style="display:inline-block; margin-left: 5px;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="diterima">
                                            <span class="text-danger fw-semibold">
                                                Karyawan yang mengantar: {{ $sewa->karyawan->nama_karyawan ?? '' }} - {{ $sewa->karyawan->no_telepon ?? '' }}
                                            </span>
                                            <button type="submit" class="btn btn-secondary text-white btn-sm">Tandai sudah diterima</button>
                                        </form>
                                        @endif

                                        @if ($sewa->status == 'diterima')
                                        <form action="{{ route('sewa.updateStatus', $sewa->id) }}" method="POST" style="display:inline-block; margin-left: 5px;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="btn btn-secondary text-white btn-sm">Tandai sudah dikembalikan</button>
                                        </form>
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


@foreach($sewas as $sewa)
<!-- Assign Karyawan Modal -->
<div class="modal fade" id="assignKaryawanModal-{{ $sewa->id }}" tabindex="-1" aria-labelledby="assignKaryawanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignKaryawanModalLabel">Tugaskan Karyawan untuk Sewa {{ $sewa->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sewa.assignKaryawan', $sewa->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="karyawan_id" class="form-label">Pilih Karyawan</label>
                        <select class="form-select" name="karyawan_id" id="karyawan_id" required>
                            <option value="">Pilih Karyawan</option>
                            @foreach($karyawans as $karyawan)
                                <option value="{{ $karyawan->id }}">{{ $karyawan->nama_karyawan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tugaskan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
