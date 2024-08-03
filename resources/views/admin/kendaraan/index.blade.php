@extends('layouts.dashboard')

@section('title', 'Kendaraan')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow border-0">
                <div class="card-body">
                    <a href="{{ route('kendaraan.create') }}" class="btn btn-primary text-white mb-3">Tambah Kendaraan</a>

                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Foto</th>
                                    <th>Jenis</th>
                                    <th>Type</th>
                                    <th>Plat Nomor</th>
                                    <th>Tahun</th>
                                    <th>Seating Capacity</th>
                                    <th>Merk</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kendaraans as $kendaraan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kendaraan->nama }}</td>
                                        <td>
                                            @if ($kendaraan->foto)
                                                <img src="{{ asset('storage/' . $kendaraan->foto) }}" width="100" />
                                            @else
                                                No Image
                                            @endif

                                            {{-- @foreach ($kendaraan->foto as $foto)
                                                <div class="col-md-3 mb-2">
                                                    <img src="{{ asset('storage/' . $foto->foto) }}" class="img-fluid"
                                                        alt="Foto Kendaraan">
                                                </div>
                                            @endforeach --}}
                                        </td>
                                        <td>
                                            @if ($kendaraan->jenis == 'motor')
                                                <span class="badge bg-danger">{{ ucfirst($kendaraan->jenis) }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ ucfirst($kendaraan->jenis) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $kendaraan->type }}</td>
                                        <td>{{ $kendaraan->plat_nomor }}</td>
                                        <td>{{ $kendaraan->tahun }}</td>
                                        <td>{{ $kendaraan->seating_capacity ?? 'N/A' }}</td>
                                        <td>{{ $kendaraan->merk }}</td>
                                        <td>Rp {{ number_format($kendaraan->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('kendaraan.edit', $kendaraan->id) }}"
                                                    class="btn btn-warning text-white btn-sm">Edit</a>
                                                <form action="{{ route('kendaraan.destroy', $kendaraan->id) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm text-white">Hapus</button>
                                                </form>
                                            </div>
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
