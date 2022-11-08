@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col">
            <h1>{{ $title }}</h1>
        </div>
    </div>

    <div class="row table-responsive mt-2 pt-1">
        <div class="col">
            <table id="table"
                class="table border table-striped table-sm table-hover align-middle text-capitalize text-center ">
                <thead>
                    <th>NO</th>
                    <th>NO STPB</th>
                    <th>Driver</th>
                    <th>Kopel</th>
                    <th>Barang</th>
                    <th>Konfirmasi</th>
                </thead>

                @if (!$pengirimans->isEmpty())
                    @foreach ($pengirimans as $pengiriman)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $pengiriman->no_stpb }}</td>
                            <td class="text-start">{{ $pengiriman->driver->nama }}</td>
                            <td>{{ $pengiriman->kotak_peluru == 1 ? 'Ya' : 'Tidak' }}</td>
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
                            <td>
                                <!-- Button trigger modal konfirmasi -->
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#konfirmasi{{ $pengiriman->no_stpb }}">
                                    <i class="bi bi-check-lg"></i>
                                </button>

                                <!-- Modal konfirmasi-->
                                <div class="modal fade" id="konfirmasi{{ $pengiriman->no_stpb }}" tabindex="-1"
                                    aria-labelledby="konfirmasiLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="konfirmasiLabel">Konfirmasi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="/store/{{ $pengiriman->no_stpb }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="no_stpb" value="{{ $pengiriman->no_stpb }}">
                                                <div class="modal-body text-start">
                                                    <div class="mb-3">
                                                        <label for="penerima" class="col-form-label">Penerima:</label>
                                                        <input type="text" name="penerima" class="form-control"
                                                            id="penerima" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="keterangan" class="col-form-label">Keterangan:</label>
                                                        <textarea class="form-control" id="keterangan" name="keterangan" autocomplete="off"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">--- Kosong ---</td>
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
                columnDefs: [{
                    targets: [5],
                    orderable: false,
                }]
            });
        });
    </script>
@endsection
