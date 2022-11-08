@extends('layouts.main')
@section('container')
    <div class="col-6 bg-white px-3 py-2 shadow">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h2>{{ $title }}<h2>
        </div>
        <form action="{{ url()->previous() }}" method="post">
            @csrf
            <input type="hidden" name="driver" value="{{ $data['driver'] }}">
            <input type="hidden" name="no_polisi" value="{{ $data['no_polisi'] }}">
            <input type="hidden" name="kategori" value="{{ $data['kategori'] }}">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </button>
            <a type="submit" href="{{ url()->previous() }}">
        </form>
        </a>
        <hr>
        <div class="row">
            <h4><i>Driver</i></h4>
            <div class="col-md">
                <table class="table">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $driver->nama }}</td>
                    </tr>
                    <tr>
                        <td>No Telepon</td>
                        <td>:</td>
                        <td>{{ $driver->no_telepon }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>{{ $driver->email }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <h4>Kotak Peluru</h4>
        <div class="row mt-3">
            <div class="col-md-3">
                <form action="/pengiriman" method="post">
                    @csrf
                    <input type="hidden" name="driver" value="{{ $driver->id }}">
                    <input type="hidden" name="kategori" value="{{ $kategori }}">
                    <input type="hidden" name="no_polisi" value="{{ $no_polisi }}">

                    <table class="border">
                        @foreach ($kodeTokos as $kodeToko)
                            <tr>
                                <td>
                                    <div class="input-group-text">
                                        <input class="form-check-input" type="checkbox" name="check[]"
                                            value="{{ $kodeToko }}" aria-label="Checkbox for following text input">
                                        <input type="hidden" name="tokoTujuan[]" value="{{ $kodeToko }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="mx-2">
                                        {{ $kodeToko }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
