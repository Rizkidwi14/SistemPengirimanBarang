@extends('layouts.main')

@section('container')
    <div class="col-8 bg-white px-3 py-2 shadow">
        <div class="row text-center">
            <h1> {{ $title }}</h1>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="row">
                <div class="col text-center">
                    @if ($driver->foto)
                        <img src="{{ asset('storage/' . $driver->foto) }}" class="img-fluid" alt="..." width="300px">
                    @else
                        <img src="/image/blank.png" class="img-fluid" alt="..." width="300px">
                    @endif
                </div>
                <div class="col">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td> Nama </td>
                                <td> : </td>
                                <td class="text-capitalize"> {{ $driver->nama }}</td>
                            </tr>
                            <tr>
                                <td> NIK </td>
                                <td> : </td>
                                <td class="text-uppercase"> {{ $driver->nik }}</td>
                            </tr>
                            <tr>
                                <td> Email </td>
                                <td> : </td>
                                <td> {{ $driver->email }}</td>
                            </tr>
                            <tr>
                                <td> No Telepon </td>
                                <td> : </td>
                                <td> {{ $driver->no_telepon }}</td>
                            </tr>
                        </table>
                        <a href="/driver" class="btn btn-primary">Kembali</a>

                        <!-- Ubah -->
                        <a href="/driver/{{ $driver->slug }}/edit" class="btn btn-warning">Ubah</a>

                        <!-- Hapus -->
                        <form action="/driver/{{ $driver->slug }}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('Data akan dihapus?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
