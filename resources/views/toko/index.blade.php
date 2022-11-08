@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col">
            <h1>Data Toko</h1>
            <a href="/toko/create" class="btn btn-primary">Tambah Toko</a>
        </div>
    </div>
    <div class="row table-responsive mt-2 pt-1">
        <table id="table"
            class="table border table-striped table-sm table-hover align-middle text-capitalize text-center ">
            <thead>
                <th>NO</th>
                <th>Kode Toko</th>
                <th>Nama Toko</th>
                <th>Alamat</th>
                <th>24Jam</th>
                <th>Status</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($tokos as $toko)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $toko->kode_toko }}</td>
                        <td class="text-start">{{ $toko->nama_toko }}</td>
                        <td>{{ $toko->alamat }}</td>
                        @if ($toko->operasional > 0)
                            <td class="text-success">Ya</td>
                        @else
                            <td class="text-danger">Tidak</td>
                        @endif

                        @if ($toko->status > 0)
                            <td>Aktif</td>
                        @else
                            <td class="text-danger">Tidak Aktif</td>
                        @endif
                        <td>
                            {{-- Ubah Toko --}}
                            <a href="/toko/{{ $toko->kode_toko }}/edit" class="btn btn-warning btn-sm">Ubah</a>
                            {{-- Hapus Toko --}}
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#delete{{ $toko->kode_toko }}">
                                Hapus
                            </button>

                            <div class="modal fade" id="delete{{ $toko->kode_toko }}" tabindex="-1"
                                aria-labelledby="deleteLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title" id="deleteLabel"><b>WARNING!</b></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="/toko/{{ $toko->kode_toko }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <input type="hidden" name="kode_toko" value="{{ $toko->kode_toko }}">
                                            <div class="modal-body text-center">
                                                <div class="mb-3">
                                                    Data yang berhubungan dengan toko <b>{{ $toko->kode_toko }}</b> akan
                                                    terhapus juga!
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('datatable')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                columnDefs: [{
                    targets: [4, 6],
                    orderable: false,
                }]
            });
        });
    </script>
@endsection
