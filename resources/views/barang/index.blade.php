@extends('layouts.main')

@section('container')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row ">
        <div class="col">
            <h1>{{ $title }}</h1>
            {{-- Button Tambah Stock --}}
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                Tambah Barang
            </button>

            {{-- Modal Tambah Stok --}}
            <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Data Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('barang.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-select" name="kategori" id="kategori" required>
                                        <option value="" selected hidden> Pilih Kategori</option>
                                        <option value="reguler"> Reguler</option>
                                        <option value="fresh food"> Fresh Food</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="namaBarang" class="form-label">Nama Barang</label>
                                    <input type="text" name="namaBarang" class="form-control" id="namaBarang" required>
                                </div>
                                <div class="mb-2">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" name="stok" class="form-control" id="stok" min="0"
                                        pattern="[0-9]" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <a href="/barang/riwayat" class="btn btn-primary btn-sm">Riwayat Perubahan Stok</a>

        </div>
    </div>
    <div class="row table-responsive pt-1">
        <div class="col">
            <hr>
            <table id="tableReguler"
                class="table border table-striped table-sm table-hover align-middle text-capitalize text-center ">
                <thead>
                    <th>NO</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $barang->kode }}</td>
                            <td class="text-start">{{ $barang->nama }}</td>
                            <td class="text-start">{{ $barang->kategori }}</td>
                            <td class="text-end">{{ number_format($barang->stok) }}</td>
                            <td>
                                <div class="hstack gap-2 justify-content-center">
                                    {{-- Tombol Ubah Stok --}}
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalTambah{{ $barang->kode }}">
                                        <i class="bi bi-plus-slash-minus"></i>
                                    </button>

                                    {{-- Modal Ubah Stok --}}
                                    <div class="modal fade" id="modalTambah{{ $barang->kode }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Ubah Stok Barang</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="/barang/{{ $barang->kode }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body text-start">
                                                        <div class="mb-2">
                                                            <label for="stokSistem" class="form-label">Stok Sistem</label>
                                                            <input type="number" value="{{ $barang->stok }}"
                                                                class="form-control" id="stok" min="0"
                                                                pattern="[0-9]" required readonly>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="stokFisik" class="form-label">Stok Fisik</label>
                                                            <input type="number" name="stokFisik" class="form-control"
                                                                id="stok" min="1" pattern="[0-9]" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tombol Ubah Data Barang --}}
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalUbah{{ $barang->kode }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    {{-- Modal Ubah Data Barang --}}
                                    <div class="modal fade" id="modalUbah{{ $barang->kode }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Ubah Data Barang</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="/barang/{{ $barang->kode }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <div class="modal-body text-start">
                                                        <div class="mb-2">
                                                            <label for="kodeBarang" class="form-label">Kode
                                                                Barang</label>
                                                            <input type="text" name="kodeBarang"
                                                                value="{{ $barang->kode }}"
                                                                class="form-control text-uppercase" id="kodeBarang"
                                                                required>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="namaBarang" class="form-label">Nama Barang</label>
                                                            <input type="text" name="namaBarang"
                                                                value="{{ $barang->nama }}" class="form-control"
                                                                id="namaBarang" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="/barang/{{ $barang->kode }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Data barang akan dihapus?')">
                                            <i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('datatable')
    <script>
        $(document).ready(function() {
            $('#tableReguler').DataTable({
                pageLength: 50,
                scrollY: '50vh',
                scrollCollapse: true,
                columnDefs: [{
                    targets: [5],
                    orderable: false,
                }]
            });
        });
    </script>
@endsection
