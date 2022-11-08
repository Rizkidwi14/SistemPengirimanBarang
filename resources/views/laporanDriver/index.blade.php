@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-9">
            <h1>{{ $title }}</h1>
        </div>
    </div>
    <div class="row table-responsive mt-2 pt-1">
        <table id="table" class="table border table table-sm table-hover align-middle text-capitalize text-center ">
            <thead>
                <th>NO</th>
                <th>NO Faktur</th>
                <th>Toko</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th></th>
                <th>Tarif</th>
                <th>Waktu Kirim</th>
                <th>Waktu Terima</th>
            </thead>


            @if (!$pengirimans->isEmpty())
                @foreach ($pengirimans as $pengiriman)
                    <tr>
                        <td> {{ $loop->iteration }}.</td>
                        <td>{{ $pengiriman->no_faktur }}</td>
                        <td class="text-start">{{ $pengiriman->toko->nama_toko }}</td>
                        <td>{{ date('d/m/Y', strtotime($pengiriman->tanggal)) }}</td>

                        @if ($pengiriman->status == 0)
                            <td> Pending </td>
                        @elseif ($pengiriman->status == 1)
                            <td>Dalam Perjalanan</td>
                        @else
                            <td>Selesai</td>
                        @endif

                        <td>Rp.</td>
                        <td class="text-center">{{ number_format($pengiriman->tarif) }}</td>

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
            $.fn.dataTable.moment('D/M/YYYY');
            $('#table').DataTable();
        });
    </script>
@endsection
