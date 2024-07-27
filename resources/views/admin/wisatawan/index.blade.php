@extends('layouts.dashboard')

@section('title', 'Data Wisatawan')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow border-0">
             
                <div class="card-body">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                <th>Alamat</th>
                                <th>KTP</th>
                                <th>NPWP</th>
                                <th>SIM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wisatawans as $wisatawan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $wisatawan->nama }}</td>
                                <td>{{ $wisatawan->user->email }}</td>
                                <td>{{ $wisatawan->no_telepon }}</td>
                                <td>{{ $wisatawan->alamat }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $wisatawan->ktp) }}" alt="KTP" width="100">
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $wisatawan->npwp) }}" alt="NPWP" width="100">
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $wisatawan->sim) }}" alt="SIM" width="100">
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
