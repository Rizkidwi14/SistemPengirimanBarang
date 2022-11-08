@extends('layouts.main')

@section('container')
    <div class="row d-flex">
        <div class="bg-light px-3 border shadow">
            <div class="row justify-content-between">
                <div class="d-flex">
                    <div class="p-2 text-center">
                        <h1>{{ $title }} </h1>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ Request::is('laporan/pengiriman*') ? '/laporan/pengiriman' : '/laporan/store' }}">
                            <i class="bi bi-x fs-1 text-black"></i></a>
                    </div>
                </div>
            </div>
            <div class="row table-responsive">
                <div class="col-6 p-2">
                    <table class="table table-bordered">
                        <tbody class="table-group-divider">
                            <tr>
                                <td colspan="2" class="text-center text-light" style="background-color: #4f6475;">
                                    <b>PENGIRIMAN</b>
                                </td>
                            </tr>
                            <tr>
                                <td><b>NOMOR STPB</b></td>
                                <td>{{ $pengiriman->no_stpb }}</td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <td class="text-capitalize">{{ $pengiriman->kategori }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>{{ date('d/m/Y', strtotime($pengiriman->tanggal)) }}</td>
                            </tr>
                            <tr>
                                <td>No. Polisi</td>
                                <td class="text-uppercase">{{ $pengiriman->no_polisi }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center text-light" style="background-color: #4f6475;">
                                    <b>DRIVER</b>
                                </td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>{{ $driver->nama }}</td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>{{ $driver->nik }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Telepon</td>
                                <td>{{ $driver->no_telepon }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $driver->email }}</td>
                            </tr>
                            <tr>
                            <tr>
                                <td colspan="2" class="text-center text-light" style="background-color: #4f6475;">
                                    <b>TOKO</b>
                                </td>
                            </tr>
                            <tr>
                                <td>Kode Toko</td>
                                <td>{{ $toko->kode_toko }}</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>{{ $toko->nama_toko }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>{{ $toko->alamat }}</td>
                            </tr>
                            <tr>
                                <td colspan='2' class="text-center text-light" style="background-color: #4f6475;">
                                    <b>KETERANGAN
                                        PENGIRIMAN</b>
                                </td>
                            </tr>

                            <tr>
                                <td>Kotak Peluru</td>
                                @if ($pengiriman->kotak_peluru == 1)
                                    <td>Ya</td>
                                @else
                                    <td>Tidak</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Waktu Kirim</td>
                                <td>{{ date('H:i', strtotime($pengiriman->waktu_kirim)) }}</td>
                            </tr>
                            <tr>
                                <td>Waktu Terima</td>
                                <td>{{ date('H:i', strtotime($pengiriman->waktu_terima)) }}</td>
                            </tr>
                            <tr>
                                <td>Penerima</td>
                                <td>{{ $pengiriman->penerima }}</td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>{{ $pengiriman->keterangan }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-6 p-2">
                    <table class="table table-bordered">
                        <tbody class="table-group-divider">
                            <tr>
                                <td colspan="3" class="text-center text-light" style="background-color: #4f6475;">
                                    <b>BARANG</b>
                                </td>
                            </tr>
                            <tr class="fw-bold text-center">
                                <td style="width:50px">No.</td>
                                <td>Kode Barang</td>
                                <td>Jumlah</td>
                            </tr>
                            @if ($pengiriman->barang)
                                @foreach (json_decode($pengiriman->barang) as $barang)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $barang->kodeBarang }}</td>
                                        <td class="text-end pe-4">{{ number_format($barang->jumlahBarang) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
