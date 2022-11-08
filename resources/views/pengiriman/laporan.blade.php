@extends('layouts.main')

@section('container')
    <div class="col bg-light px-3 py-2 shadow">
        <div class="row">
            <div class="col-4">
                <h1>{{ $title }} </h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="hstack gap-3">
                    <div>
                        <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapsePengirimanCari" aria-expanded="false"
                            aria-controls="collapsePengirimanCari">
                            Filter
                        </button>
                    </div>
                    <div class="ms-auto">
                        @if (Request::is('laporan/pengiriman'))
                            <a target="_blank" href="/laporan/pengiriman/cetak" class="btn btn-primary">Cetak</a>
                        @elseif (Request::is('laporan/pengiriman/cari'))
                            <form action="/laporan/pengiriman/cari/cetak" method="post" target="_blank">
                                @csrf
                                <input type="hidden" name="toko" value="{{ $data['toko'] }}">
                                <input type="hidden" name="tanggalawal" value="{{ $data['tanggalawal'] }}">
                                <input type="hidden" name="tanggalakhir" value="{{ $data['tanggalakhir'] }}">
                                <button type="submit" class="btn btn-primary">Cetak</button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="collapse mt-2 {{ Request::is('pengiriman/laporan/cari') ? 'show' : '' }}"
                            id="collapsePengirimanCari">
                            <div class="card card-body">
                                <form action="/laporan/pengiriman/cari" method="post">
                                    @csrf
                                    <div class="mb-2">
                                        <label for="toko" class="form-label">Toko</label>
                                        <label class="form-label text-secondary">(Opsional)</label>
                                        <input type="text" name="toko" id="toko"
                                            class="form-control @error('toko') is-invalid @enderror"
                                            value="{{ $data['toko'] }}" autocomplete="off">
                                        <div class="form-text">Opsional</div>

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
                </div>
            </div>

        </div>
        <div class="row table-responsive mt-2 pt-1">
            <table id="table" class="table border table table-hover align-middle text-capitalize text-center ">
                <thead>
                    <th>NO</th>
                    <th>NO STPB</th>
                    <th>Toko</th>
                    <th>Driver</th>
                    <th>Kopel</th>
                    <th>Tanggal</th>
                    <th>Waktu Kirim</th>
                    <th>Waktu Terima</th>
                    <th>Barang</th>
                    <th>Status</th>
                </thead>


                @if (!$pengirimans->isEmpty())
                    @foreach ($pengirimans as $pengiriman)
                        <tr>
                            <td> {{ $loop->iteration }}.</td>
                            <td>{{ $pengiriman->no_stpb }}</td>
                            <td class="text-start has-details">
                                {{ $pengiriman->toko->kode_toko }}
                                <span class="border shadow rounded details">{{ $pengiriman->toko->nama_toko }}</span>
                            </td>
                            <td class="text-start">{{ $pengiriman->driver->nama }}</td>
                            <td class="text-start">{{ $pengiriman->kotak_peluru == 1 ? 'Ya' : 'Tidak' }}</td>
                            <td>{{ date('d/m/Y', strtotime($pengiriman->tanggal)) }}</td>

                            {{-- Waktu kirim --}}
                            <td>
                                {{ $pengiriman->waktu_kirim ? date('H:i', strtotime($pengiriman->waktu_kirim)) : '-' }}
                            </td>

                            {{-- Waktu Terima --}}
                            <td>
                                {{ $pengiriman->waktu_terima ? date('H:i', strtotime($pengiriman->waktu_terima)) : '-' }}
                            </td>

                            {{-- Barang --}}
                            <td>
                                <!-- Button trigger modal lihat barang-->
                                <a class="text-dark" href="#" data-bs-toggle="modal"
                                    data-bs-target="#barang{{ $pengiriman->no_stpb }}">View</a>

                                <!-- Modal barang-->
                                <div class="modal fade" id="barang{{ $pengiriman->no_stpb }}" tabindex="-1"
                                    aria-labelledby="barangLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="barangLabel">List Barang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <table class="table table-bordered">
                                                <tbody class="table-group-divider">
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
                                                                <td class="text-end pe-4">
                                                                    {{ number_format($barang->jumlahBarang) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Status --}}
                            @if ($pengiriman->status == 0)
                                <td class="table-warning"> Pending </td>
                            @elseif ($pengiriman->status == 1)
                                <td class="table-info">Dalam Perjalanan</td>
                            @elseif ($pengiriman->status == 2)
                                <td class="table-success">
                                    <a class="text-dark" href="/laporan/pengiriman/{{ $pengiriman->no_stpb }}"
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
    </div>

@endsection

@section('datatable')
    <script>
        $(document).ready(function() {
            $.fn.dataTable.moment('D/M/YYYY');
            $('#table').DataTable({
                pageLength: 50,
                scrollY: '50vh',
                scrollCollapse: true,
            });
        });
    </script>
@endsection
