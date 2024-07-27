@extends('layouts.dashboard')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow border-0">
            <div class="card-header">
                <h4 class="fw-semibold text-primary">{{ __('Edit Kendaraan') }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('kendaraan.update', $kendaraan->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="nama">Nama Kendaraan</label>
                                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $kendaraan->nama) }}" required>
                                @error('nama')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="foto">Foto Kendaraan</label>
                                <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror">
                                @error('foto')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                @if($kendaraan->foto)
                                    <img src="{{ asset('storage/' . $kendaraan->foto) }}" width="100" class="mt-2" />
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="jenis">Jenis</label>
                                <select id="jenis" name="jenis" class="form-control @error('jenis') is-invalid @enderror" required>
                                    <option value="mobil" {{ old('jenis', $kendaraan->jenis) == 'mobil' ? 'selected' : '' }}>Mobil</option>
                                    <option value="motor" {{ old('jenis', $kendaraan->jenis) == 'motor' ? 'selected' : '' }}>Motor</option>
                                </select>
                                @error('jenis')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <input type="text" id="type" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $kendaraan->type) }}" required>
                                @error('type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="plat_nomor">Plat Nomor</label>
                                <input type="text" id="plat_nomor" name="plat_nomor" class="form-control @error('plat_nomor') is-invalid @enderror" value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}" required>
                                @error('plat_nomor')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $kendaraan->keterangan) }}</textarea>
                                @error('keterangan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="number" id="tahun" name="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', $kendaraan->tahun) }}" required>
                                @error('tahun')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3" id="seating_capacity_div">
                            <div class="form-group">
                                <label for="seating_capacity">Seating Capacity (Opsional)</label>
                                <input type="number" id="seating_capacity" name="seating_capacity" class="form-control @error('seating_capacity') is-invalid @enderror" value="{{ old('seating_capacity', $kendaraan->seating_capacity) }}">
                                @error('seating_capacity')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="merk">Merk</label>
                                <input type="text" id="merk" name="merk" class="form-control @error('merk') is-invalid @enderror" value="{{ old('merk', $kendaraan->merk) }}" required>
                                @error('merk')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" id="harga" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $kendaraan->harga) }}" required>
                                @error('harga')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary text-white">{{ __('Update') }}</button>
                                <a href="{{ route('kendaraan.index') }}" class="btn btn-sm btn-secondary text-white ">Kembali</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var jenisSelect = document.getElementById('jenis');
        var seatingCapacityDiv = document.getElementById('seating_capacity_div');
        
        function toggleSeatingCapacity() {
            if (jenisSelect.value === 'motor') {
                seatingCapacityDiv.style.display = 'none';
            } else {
                seatingCapacityDiv.style.display = 'block';
            }
        }
        
        // Initial check
        toggleSeatingCapacity();
        
        // Add event listener
        jenisSelect.addEventListener('change', toggleSeatingCapacity);
    });
</script>
@endsection
