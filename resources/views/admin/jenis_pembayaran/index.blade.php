<!-- resources/views/jenis_pembayaran/index.blade.php -->

@extends('layouts.dashboard')

@section('title', 'Jenis Pembayaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow border-0">
            <div class="card-header">
                <a href="{{ route('jenis_pembayaran.create') }}" class="btn btn-primary text-white">Tambah Jenis Pembayaran</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>No Rek</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jenisPembayaran as $jenis)
                            <tr>
                                <td>{{ $jenis->id }}</td>
                                <td>{{ $jenis->nama }}</td>
                                <td>{{ $jenis->no_rek }}</td>
                                <td>
                                    @if($jenis->gambar)
                                        <img src="{{ asset('storage/' . $jenis->gambar) }}" alt="{{ $jenis->nama }}" width="100">
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('jenis_pembayaran.edit', $jenis->id) }}" class="btn btn-warning btn-sm text-white">Edit</a>
                                    <form action="{{ route('jenis_pembayaran.destroy', $jenis->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm('Are you sure?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
