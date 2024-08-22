@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Daftar Karyawan</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <button class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#addKaryawanModal">Tambah Karyawan</button>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>No Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawans as $karyawan)
            <tr>
                <td>{{ $karyawan->nama_karyawan }}</td>
                <td>{{ $karyawan->no_telepon }}</td>
                <td>
                    <button class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#editKaryawanModal-{{ $karyawan->id }}">Edit</button>
                    <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger text-white">Hapus</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Karyawan Modal -->
            <div class="modal fade" id="editKaryawanModal-{{ $karyawan->id }}" tabindex="-1" aria-labelledby="editKaryawanModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editKaryawanModalLabel">Edit Karyawan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                    <input type="text" class="form-control" name="nama_karyawan" value="{{ $karyawan->nama_karyawan }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="no_telepon" class="form-label">No Telepon</label>
                                    <input type="text" class="form-control" name="no_telepon" value="{{ $karyawan->no_telepon }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary text-white">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Karyawan Modal -->
<div class="modal fade" id="addKaryawanModal" tabindex="-1" aria-labelledby="addKaryawanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKaryawanModalLabel">Tambah Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('karyawan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" name="nama_karyawan" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" name="no_telepon" required>
                    </div>
                    <button type="submit" class="btn btn-primary text-white">Tambah Karyawan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
