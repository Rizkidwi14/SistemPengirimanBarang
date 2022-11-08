@extends('layouts.main')

@section('container')
    <div class="col bg-light px-3 py-2 shadow">

        <div class="row">
            <div class="col-4">
                <h1>{{ $title }} </h1>
                <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsePengiriman" aria-expanded="false" aria-controls="collapsePengiriman">
                    Filter
                </button>
                <div class="collapse mt-2 {{ Request::is('laporan/store/cari') ? 'show' : '' }}" id="collapsePengiriman">
                    <div class="card card-body">
                        <form action="/laporan/store/cari" method="post">
                            @csrf
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
        <div class="row table-responsive mt-2 pt-1">
            <table id="table" class="table border table table-hover align-middle text-capitalize text-center ">
                <thead>
                    <th>NO</th>
                    <th>NO STPB</th>
                    <th>Driver</th>
                    <th>Tanggal</th>
                    <th>Kopel</th>
                    <th>Waktu Kirim</th>
                    <th>Waktu Terima</th>
                    <th>Penerima</th>
                    <th>Status</th>
                </thead>


                @if (!$pengirimans->isEmpty())
                    @foreach ($pengirimans as $pengiriman)
                        <tr>
                            <td> {{ $loop->iteration }}.</td>
                            <td>{{ $pengiriman->no_stpb }}</td>
                            <td class="text-start">{{ $pengiriman->driver->nama }}</td>
                            <td>{{ date('d/m/Y', strtotime($pengiriman->tanggal)) }}</td>
                            <td>{{ $pengiriman->kotak_peluru == 1 ? 'Ya' : 'Tidak' }}</td>


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

                            <!-- Penerima -->
                            @empty($pengiriman->penerima)
                                <td> - </td>
                            @else
                                <td class="text-start">{{ $pengiriman->penerima }}</td>
                            @endempty

                            {{-- Status --}}
                            @if ($pengiriman->status == 0)
                                <td class="table-warning"> Pending </td>
                            @elseif ($pengiriman->status == 1)
                                <td class="table-info">Dalam Perjalanan</td>
                            @else
                                <td class="table-success">
                                    <a class="text-dark" href="/laporan/store/{{ $pengiriman->no_stpb }}"
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
            $('#table').DataTable();
        });
    </script>
@endsection
