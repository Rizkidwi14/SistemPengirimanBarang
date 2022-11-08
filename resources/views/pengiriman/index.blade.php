@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-9">
            <h1>Pengiriman</h1>
            <a class="btn btn-primary " href="/pengiriman/create">Tambah Pengiriman</a>
        </div>
    </div>
    <div class="row table-responsive mt-2 pt-1">
        <table id="table" class="table border table table-sm table-hover align-middle text-capitalize text-center ">
            <thead>
                <th>NO</th>
                <th>NO Faktur</th>
                <th>Toko</th>
                <th>Driver</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th></th>
                <th>Tarif</th>
                <th>Waktu Kirim</th>
                <th>Waktu Terima</th>
                <th>Penerima</th>
            </thead>


            @if (!$pengirimans->isEmpty())
                @foreach ($pengirimans as $pengiriman)
                    <tr>
                        <td> {{ $loop->iteration }}.</td>
                        <td>{{ $pengiriman->no_faktur }}</td>
                        <td class="text-start">{{ $pengiriman->toko->nama_toko }}</td>
                        <td class="text-start">{{ $pengiriman->driver->nama }}</td>
                        <td>{{ date('d-m-Y', strtotime($pengiriman->tanggal)) }}</td>

                        @if ($pengiriman->status == 0)
                            <td> Menunggu Driver </td>
                        @elseif ($pengiriman->status == 1)
                            <td>Dalam Perjalanan</td>
                        @else
                            <td>Selesai</td>
                        @endif

                        <td>Rp.</td>
                        <td class="text-end">{{ number_format($pengiriman->tarif) }}</td>

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

                        <!-- Penerima -->
                        @empty($pengiriman->penerima)
                            <td> - </td>
                        @else
                            <td>{{ $pengiriman->penerima }}</td>
                        @endempty
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="12">--- Kosong ---</td>
                </tr>
            @endif
        </table>
    </div>

@endsection

@section('datatable')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
@endsection
