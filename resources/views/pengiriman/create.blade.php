@extends('layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <h1 class="h2">{{ $title }}<h1>
    </div>
    <hr>
    <form method="POST" action="/pengiriman" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                @csrf
                {{-- Toko Tujuan --}}
                <div class="mb-2">
                    <label for="toko" class="form-label">Toko Tujuan</label>
                    <input class="form-control @error('toko') is-invalid @enderror" name="toko"
                        value="{{ old('toko') }}" list="tokos" id="toko" placeholder="Cari Toko..."
                        autocomplete="off" required>
                    <datalist id="tokos">
                        @foreach ($tokos as $toko)
                            <option value="{{ $toko->kode_toko }} - {{ $toko->nama_toko }}">
                        @endforeach
                    </datalist>
                    @error('toko')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Driver --}}
                <div class="mb-2">
                    <label for="driver" class="form-label">Driver</label>
                    <input class="form-control @error('driver') is-invalid @enderror" name="driver"
                        value="{{ old('driver') }}" list="drivers" id="driver" placeholder="Cari Driver..."
                        autocomplete="off" required>
                    <datalist id="drivers">
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->nik }} - {{ $driver->nama }}">
                        @endforeach
                    </datalist>
                    @error('driver')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Nomor Polisi --}}
                <div class="mb-2">
                    <label for="no_polisi" class="form-label">Nomor Polisi</label>
                    <input type="text" name='no_polisi' id='no_polisi' required
                        class="form-control text-uppercase @error('no_polisi') is-invalid @enderror" maxlength="11"
                        value="{{ old('no_polisi', $data['no_polisi']) }}">
                    @error('no_polisi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" id="kategori"
                        value="{{ old('kategori') }}" required>
                        <option value="" selected hidden> Pilih Kategori</option>
                        <option value="reguler">Reguler</option>
                        <option value="fresh food"> Fresh Food</option>
                    </select>
                </div>
                <div class="col d-flex justify-content-between">
                    <div class="mb-2">
                        <label for="driver" class="form-label">Kotak peluru</label>
                        <div class="mb-1">
                            <input type="radio" name="kotak_peluru" id="radio1" class="mx-1 form-check-input" value="1">
                            <label class="form-check-label" for="radio1">
                                Ya
                              </label>
                        </div>
                        <div class="mb-1">
                            <input type="radio" name="kotak_peluru" id="radio2" class="mx-1 form-check-input" value="0" checked>
                            <label class="form-check-label" for="radio2">
                                Tidak
                              </label>
                        </div>
                    </div>
                    <div >
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>

            </div>

            <div class="col-md-6 offset-1">
                <div class="ps-2">
                    <button type="button" id="tambah" onclick="addRow()" class="btn btn-secondary">+ Barang</button>
                </div>
                <table id="tables" class="table">
                    <tr>
                        <th>Kode Barang</th>
                        <th>Jumlah</th>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control" name="kodeBarang[]" value="{{ old('barang') }}" list="barangs"
                                id="barang" autocomplete="off" placeholder="Pilih Kode Barang" required>
                            <datalist id="barangs">
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->kode }}">{{ $barang->nama }}</option>
                                @endforeach
                            </datalist>
                        </td>
                        <td>
                            <input type="number" name="jumlahBarang[]" class="form-control" min="1" pattern="[0-9]"
                                required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="deleteRow(this)">X</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
@endsection

@section('datatable')
    <script>
        function addRow() {

            var tbodyRef = document.getElementById('tables').getElementsByTagName('tbody')[0];
            var lastRow = tbodyRef.rows[tbodyRef.rows.length - 1];
            var lastCell = lastRow.cells[lastRow.cells.length - 1];

            // Insert a row at the end of table
            var newRow = tbodyRef.insertRow();

            // Insert a cell at the end of the row
            // var newCell = newRow.insertCell();
            // newCell.innerHTML = lastRow.rowIndex + 1;

            newCell = newRow.insertCell();
            newCell.innerHTML = `<input class="form-control" name="kodeBarang[]" value="{{ old('barang') }}" list="barangs" id="barang" autocomplete="off" placeholder="Pilih Kode Barang" required>
                            <datalist id="barangs">
                                @foreach ($barangs as $barang)
                                <option value="{{ $barang->kode }}">{{ $barang->nama }}</option>                                
                                @endforeach
                            </datalist>`;

            newCell = newRow.insertCell();
            newCell.innerHTML =
                `<input type="number" name="jumlahBarang[]" class="form-control" min="1" pattern="[0-9]" required>`;

            newCell = newRow.insertCell();
            newCell.innerHTML =
                `<button type="button" class="btn btn-danger" onclick="deleteRow(this)">X</button>`;
        }

        function deleteRow(r) {
            var i = r.parentNode.parentNode.rowIndex;
            document.getElementById("tables").deleteRow(i);
        }
    </script>
@endsection
