@extends('layouts.main')

@section('container')
    @if ($errors->any())
        <div class="alert alert-danger col-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col bg-light px-3 py-2 shadow">
        <div class="row ">
            <div class="col">
                <h1>{{ $title }}</h1>
                <a href="/barang" class="btn btn-sm btn-primary">Kembali</a>
            </div>
        </div>
        <div class="row table-responsive">
            <div class="col">
                <hr>
                <table id="table"
                    class="table border table-striped table-sm table-hover align-middle text-capitalize text-center ">
                    <thead>
                        <th>NO</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok Sistem</th>
                        <th>Stok Fisik</th>
                        <th>Selisih</th>
                        <th>Tanggal</th>
                    </thead>
                    <tbody>
                        @if (!$riwayats->isEmpty())
                            @foreach ($riwayats as $riwayat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $riwayat->kode_barang }}</td>
                                    <td class="text-start">{{ $riwayat->nama_barang }}</td>
                                    <td>{{ $riwayat->stok_sistem }}</td>
                                    <td>{{ $riwayat->stok_fisik }}</td>

                                    @if ($riwayat->keterangan == 'positif')
                                        <td class="table-success">{{ $riwayat->selisih }}</td>
                                    @elseif($riwayat->keterangan == 'negatif')
                                        <td class="table-danger">{{ $riwayat->selisih }}</td>
                                    @else
                                        <td>{{ $riwayat->selisih }}</td>
                                    @endif

                                    <td>{{ $riwayat->updated_at }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>Kosong</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('datatable')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                pageLength: 50,
                scrollY: '50vh',
                scrollCollapse: true,
            });
        });
    </script>
@endsection
