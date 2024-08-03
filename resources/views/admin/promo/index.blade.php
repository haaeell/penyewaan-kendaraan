@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-body">
            <h1>Daftar Promo</h1>
    <a href="{{ route('promos.create') }}" class="btn btn-primary text-white">Tambah Promo</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Deskripsi</th>
                <th>Jenis</th>
                <th>Nilai</th>
                <th>Gambar</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promos as $promo)
                <tr>
                    <td>{{ $promo->kode }}</td>
                    <td>{{ $promo->deskripsi }}</td>
                    <td>{{ $promo->jenis }}</td>
                    <td>{{ $promo->nilai }}</td>
                    <td>
                        @if($promo->gambar)
                            <img src="{{ $promo->getGambarUrlAttribute() }}" alt="Gambar Promo" width="100">
                        @endif
                    </td>
                    <td>{{ $promo->tanggal_mulai }}</td>
                    <td>{{ $promo->tanggal_selesai }}</td>
                    <td>{{ $promo->status ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>
                       <div class="d-flex">
                        <a href="{{ route('promos.edit', $promo->id) }}" class="btn btn-warning text-white">Edit</a>
                        <form action="{{ route('promos.destroy', $promo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger text-white">Hapus</button>
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
@endsection
