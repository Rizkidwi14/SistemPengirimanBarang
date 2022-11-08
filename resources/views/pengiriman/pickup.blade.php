@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-9">
            <h1>{{ $title }}</h1>
        </div>
    </div>
    <div class="row table-responsive mt-2 pt-1">
        <table id="table"
            class="table border table-striped table-sm table-hover align-middle text-capitalize text-center ">
            <thead>
                <th>NO</th>
                <th>NO STPB</th>
                <th>Toko</th>
                <th>Driver</th>
                <th>Kopel</th>
                <th>Barang</th>
                <th></th>
            </thead>


            @if (!empty($pengirimans))
                @foreach ($pengirimans as $pengiriman)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $pengiriman->no_stpb }}</td>
                        <td class="text-start">{{ $pengiriman->toko->kode_toko }}</td>
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
                            <div class="hstack gap-2 justify-content-center">
                                <form action="/pengiriman/pickup/{{ $pengiriman->no_stpb }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary btn-sm"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <a href="/pengiriman/{{ $pengiriman->no_stpb }}/edit" class=" btn btn-warning btn-sm"><i
                                        class="bi bi-pencil-square"></i></a>
                                <form action="/pengiriman/{{ $pengiriman->no_stpb }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Pengiriman akan dihapus?')">
                                        <i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>

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
            $('#table').DataTable({
                columnDefs: [{
                    targets: [5, 6],
                    orderable: false,
                }]
            });
        });
    </script>
@endsection
