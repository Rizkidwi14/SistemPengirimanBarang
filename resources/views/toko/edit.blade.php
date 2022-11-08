@extends('layouts.main')

@section('container')
    <div class="col-5 bg-light px-3 py-2 shadow">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mb-2">
            <h1 class="h2">Edit Data Toko<h1>
        </div>

        <div class="row align-items-start">
            <form method="POST" action="/toko/{{ $toko->kode_toko }}" class="mb-5" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="col-md">
                    {{-- Kode Toko --}}
                    <div class="mb-2">
                        <label for="kode_toko" class="form-label">Kode Toko</label>
                        <input type="text" name="kode_toko" id="kode_toko"
                            class="form-control text-uppercase @error('kode_toko') is-invalid @enderror"
                            value="{{ old('kode_toko', $toko->kode_toko) }}" autocomplete="off" required autofocus>
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
                            value="{{ old('nama_toko', $toko->nama_toko) }}" required autocomplete="off">
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
                            class="form-control @error('alamat') is-invalid @enderror"
                            value="{{ old('alamat', $toko->alamat) }}" required autocomplete="off">
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
                            @if ($toko->operasional > 0)
                                <option value="1" selected hidden>24 Jam</option>
                            @else
                                <option value="0" selected hidden>Tidak 24 Jam</option>
                            @endif
                            <option value="1">24 Jam</option>
                            <option value="0">Tidak 24 Jam</option>
                        </select>
                        @error('operasional')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            @if ($toko->status > 0)
                                <option value="1" selected hidden>Aktif</option>
                            @else
                                <option value="0" selected hidden>Tidak Aktif</option>
                            @endif
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
@endsection
