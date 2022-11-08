@extends('layouts.main')

@section('container')
    <div class="col-5 bg-light px-3 py-2 shadow">
        <div class="ps-1">
            <div class="row">
                <div>
                    <h1 class="h2">Tambah Data Toko<h1>
                </div>
                <form method="POST" action="/toko" class="mb-5" enctype="multipart/form-data">
                    @csrf
                    {{-- Kode Toko --}}
                    <div class="mb-2">
                        <label for="kode_toko" class="form-label">Kode Toko</label>
                        <input type="text" name="kode_toko" id="kode_toko"
                            class="form-control text-uppercase @error('kode_toko') is-invalid @enderror"
                            value="{{ old('kode_toko', $kodeToko) }}" autocomplete="off" maxlength="4" required autofocus>
                        @error('kode_toko')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Nama Toko --}}
                    <div class="mb-2">
                        <label for="nama_toko" class="form-label">Nama Toko</label>
                        <input type="text" name="nama_toko" id="nama_toko"
                            class="form-control text-capitalize @error('nama_toko') is-invalid @enderror"
                            value="{{ old('nama_toko') }}" required autocomplete="off">
                        @error('nama_toko')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="mb-2">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat"
                            class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}" required
                            autocomplete="off" maxlength="100">
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Jam Operasional --}}
                    <div class="mb-3">
                        <label for="operasional" class="form-label">Jam Operasional</label>
                        <select class="form-select @error('operasional') is-invalid @enderror" name="operasional" required>
                            <option value="1">24 Jam</option>
                            <option value="0">Tidak 24 Jam</option>
                        </select>
                        @error('operasional')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah Toko</button>
                </form>
            </div>
        </div>
    </div>
@endsection
