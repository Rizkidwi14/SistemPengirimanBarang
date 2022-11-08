@extends('layouts.main')
@section('container')
    <div class="col-6 bg-white px-3 py-2 shadow">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h2>{{ $title }}<h2>
        </div>
        <a href="/barang" target="_blank" class="btn btn-sm btn-warning text-dark">Periksa Ketersediaan Stok</a>
        <hr>
        <div class="row">
            <div class="col-md">
                <table class="table">
                    <tr>
                        <td>Toko Tujuan</td>
                        <td>:</td>
                        <td><b>{{ $kodeTokos[0] }}</b></td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td>:</td>
                        <td>{{ $data['kategori'] }}</td>
                    </tr>
                    <tr>
                        <td>Driver</td>
                        <td>:</td>
                        <td>{{ $driver->nama }}</td>
                    </tr>
                    <tr>
                        <td>No Polisi</td>
                        <td>:</td>
                        <td>{{ $data['no_polisi'] }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <form action="/pengiriman/create/proses" method="POST">
            @csrf
            <input type="hidden" name="kodeToko" value="{{ $kodeTokos[0] }}">
            <input type="hidden" name="driver" value="{{ $data['driver'] }}">
            <input type="hidden" name="no_polisi" value="{{ $data['no_polisi'] }}">
            <input type="hidden" name="kategori" value="{{ $data['kategori'] }}">

            {{-- Loop Kode Toko --}}
            @foreach ($kodeTokos as $kodetoko)
                <input type="hidden" name="kodeTokoArray[]" value="{{ $kodetoko }}">
            @endforeach

            <div class="d-flex justify-content-between">
                <div>
                    <button type="button" id="tambah" onclick="add()" class="btn btn-secondary">+ Barang</button>
                </div>
                <div class="btn btn-secondary me-2">
                    <label for="checkbox" class="form-input-label">Kotak Peluru</label>
                    <input type="checkbox" id="checkbox" name="kotakPeluru" value="1" class="form-input-check">
                </div>
            </div>
            <div class="col">
                <table id="table" class="table">
                    <tr>
                        <th>No.</th>
                        <th>Kode Barang</th>
                        <th>Jumlah<sup>*</sup></th>
                    </tr>
                    <tr>
                        <td>1.</td>
                        <td>
                            <select name="kodeBarang[]" class="form-control" id="barang">
                                <option value="" selected hidden>Pilih Kode Barang</option>
                                <option value="">Tidak ada</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->kode }}">{{ $barang->kode }} - {{ $barang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="jumlahBarang[]" class="form-control" min="1" pattern="[0-9]">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col d-flex justify-content-between">
                <div class="form-text">*Barang tidak akan terkirim jika jumlah kosong</div>
                <button type="submit" class="btn btn-primary">Selanjutnya</button>
            </div>
        </form>
    </div>
    <script>
        function add() {

            var tbodyRef = document.getElementById('table').getElementsByTagName('tbody')[0];
            var lastRow = tbodyRef.rows[tbodyRef.rows.length - 1];
            var lastCell = lastRow.cells[lastRow.cells.length - 1];

            // Insert a row at the end of table
            var newRow = tbodyRef.insertRow();

            // Insert a cell at the end of the row
            var newCell = newRow.insertCell();
            newCell.innerHTML = lastRow.rowIndex + 1;

            newCell = newRow.insertCell();
            newCell.innerHTML = `<select name="kodeBarang[]" class="form-control"><option value="" selected hidden>Pilih Kode Barang</option><option value="" >Tidak ada</option>@foreach ($barangs as $barang)<option value="{{ $barang->kode }}">{{ $barang->kode }} - {{ $barang->nama }}</option>@endforeach</select>`;

            newCell = newRow.insertCell();
            newCell.innerHTML = `<input type="number" name="jumlahBarang[]" class="form-control" min="1" pattern="[0-9]">`;
        }
    </script>
@endsection
