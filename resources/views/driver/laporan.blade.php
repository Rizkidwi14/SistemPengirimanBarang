@extends('layouts.main')

@section('container')
    @if (Request::isMethod('get'))
        <div class="col-4 bg-light px-3 py-3 shadow">
    @endif
    <div class="row">
        <div class={{ Request::isMethod('get') ? 'col' : 'col-4 ' }}>
            <h1>{{ $title }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="hstack gap-3">
            <div class={{ Request::isMethod('get') ? 'col' : 'col-4' }}>
                <div class="card">
                    <div class="card-body">
                        <form action="/laporan/driver" method="post">
                            @csrf
                            <div class="mb-2">
                                <label for="driver" class="form-label">Driver</label>
                                <input class="form-control" name="driver" list="drivers" id="driver"
                                    placeholder="Cari Driver..." value="{{ $data['clicked'] }}" autocomplete="off" required>
                                <datalist id="drivers">
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->nik }} - {{ $driver->nama }}">
                                    @endforeach
                                </datalist>
                                @error('driver')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="tanggalawal" class="form-label">Range Tanggal</label>
                                <input type="date" name="tanggalawal" id="tanggalawal"
                                    class="form-control @error('tanggalawal') is-invalid @enderror"
                                    value="{{ $data['tanggalawal'] }}" autocomplete="off" required>
                                @error('tanggalawal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <input type="date" name="tanggalakhir" id="tanggalakhir"
                                    class="form-control @error('tanggalakhir') is-invalid @enderror"
                                    value="{{ $data['tanggalakhir'] }}" autocomplete="off" required>
                                @error('tanggalakhir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
            @if ($data['clicked'])
                <div class="col-5 offset-1">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Driver</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td class="text-capitalize">{{ $driverSearch->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>{{ $driverSearch->email }}</td>
                                </tr>
                                <tr>
                                    <td>No Telepon</td>
                                    <td>:</td>
                                    <td>{{ $driverSearch->no_telepon }}</td>
                                </tr>
                                <tr>
                                    <td>Periode</td>
                                    <td>:</td>
                                    <td>{{ date('d/m/Y', strtotime($data['tanggalawal'])) }} -
                                        {{ date('d/m/Y', strtotime($data['tanggalakhir'])) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="ms-auto align-self-end">
                    <form action="/laporan/driver/cetak" method="post" target="_blank">
                        @csrf
                        <input type="hidden" name="idDriver" value="{{ $driverSearch->id }}">
                        <input type="hidden" name="tanggalawal" value="{{ $data['tanggalawal'] }}">
                        <input type="hidden" name="tanggalakhir" value="{{ $data['tanggalakhir'] }}">
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    @if ($data['clicked'])
        <div class="row table-responsive mt-2 pt-1">
            <table id="table" class="table border table table-hover align-middle text-capitalize text-center ">
                <thead>
                    <th>NO</th>
                    <th>NO STPB</th>
                    <th>Toko</th>
                    <th>Tanggal</th>
                    <th>Waktu Kirim</th>
                    <th>Waktu Terima</th>
                    <th>Status</th>
                </thead>


                @if (!$pengirimans->isEmpty())
                    @foreach ($pengirimans as $pengiriman)
                        <tr>
                            <td> {{ $loop->iteration }}.</td>
                            <td>{{ $pengiriman->no_stpb }}</td>
                            <td class="text-start">{{ $pengiriman->toko->kode_toko }}</td>
                            {{-- <td>{{ $pengiriman->tanggal }}</td> --}}
                            <td>{{ date('d/m/Y', strtotime($pengiriman->tanggal)) }}</td>

                            {{-- Waktu Kirim --}}
                            @empty($pengiriman->waktu_kirim)
                                <td> - </td>
                            @else
                                <td>{{ date('H:i', strtotime($pengiriman->waktu_kirim)) }}</td>
                            @endempty

                            {{-- Waktu Terima --}}
                            @empty($pengiriman->waktu_terima)
                                <td> - </td>
                            @else
                                <td>{{ date('H:i', strtotime($pengiriman->waktu_terima)) }}</td>
                            @endempty

                            {{-- Status --}}
                            @if ($pengiriman->status == 0)
                                <td class="table-warning"> Pending </td>
                            @elseif ($pengiriman->status == 1)
                                <td class="table-info">Dalam Perjalanan</td>
                            @elseif ($pengiriman->status == 2)
                                <td class="table-success">
                                    <a class="text-dark" href="/pengiriman/{{ $pengiriman->no_stpb }}"
                                        role="button">Selesai</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="12">--- Kosong ---</td>
                    </tr>
                @endif
            </table>
        </div>
    @endif
@endsection

@section('datatable')
    <script>
        $(document).ready(function() {
            $.fn.dataTable.moment('D/M/YYYY');
            $('#table').DataTable({});
        });
    </script>
@endsection
