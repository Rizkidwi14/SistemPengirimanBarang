@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-9">
            <h1>
                @can('admin')
                    <a href="/pengiriman/laporan" class="text-decoration-none text-dark">
                        {{ $title }}
                    </a>
                    <a href="/pengiriman/create">
                        <small>
                            <i class="bi bi-plus-circle"></i>
                        </small>
                    </a>
                @endcan

                @can('toko')
                    {{ $title }}
                @endcan

                @can('manajer')
                    {{ $title }}
                @endcan

            </h1>
        </div>
    </div>

    @can('admin')
        <div class="row">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card text-bg-primary">
                        <div class="card-header bg-primary text-light text-center fs-4">Pengiriman Hari Ini</div>
                        <div class="card-body">
                            <table class="displayTable table border table table-hover align-middle text-capitalize text-center">
                                <thead>
                                    <th>NO</th>
                                    <th>NO STPB</th>
                                    <th>Driver</th>
                                    <th>Toko</th>
                                    <th>Kopel</th>
                                    <th>Status</th>
                                </thead>

                                @if (!$pengirimans->isEmpty())
                                    @foreach ($pengirimans as $pengiriman)
                                        <tr>
                                            <td> {{ $loop->iteration }}.</td>
                                            <td>{{ $pengiriman->no_stpb }}</td>
                                            <td class="text-start">{{ $pengiriman->driver->nama }}</td>
                                            <td class="text-start">{{ $pengiriman->toko->kode_toko }}</td>
                                            <td>{{ $pengiriman->kotak_peluru == 1 ? 'Ya' : 'Tidak' }}</td>


                                            {{-- Status --}}
                                            @if ($pengiriman->status == 0)
                                                <td class="table-warning">Pending </td>
                                            @elseif ($pengiriman->status == 1)
                                                <td class="table-info">Dalam Perjalanan</td>
                                            @else
                                                <td class="table-success">
                                                    <a class="text-dark"
                                                        href="{{ route('laporan.pengiriman.detail', $pengiriman->no_stpb) }}"
                                                        role="button">Selesai</a>
                                                </td>
                                            @endif
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
                </div>
                <div class="col-lg-6">
                    <div class="card text-bg-primary">
                        <div class="card-header bg-primary text-light text-center fs-4">Jumlah Pengiriman {{ $tahun }}
                        </div>
                        <div class="card-body">
                            <div>
                                <canvas id="chartPengiriman"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('toko')
                <div class="row">
                    <div class="col">
                        <p class="fs-3">Pengiriman</p>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table class="displayTable table border table table-hover align-middle text-capitalize text-center">
                                <thead>
                                    <th>NO</th>
                                    <th>NO STPB</th>
                                    <th>Driver</th>
                                    <th>Kopel</th>
                                    <th>Barang</th>
                                    <th>Status</th>
                                </thead>

                                @if (!$stores->isEmpty())
                                    @foreach ($stores as $store)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $store->no_stpb }}</td>
                                            <td class="text-start">{{ $store->driver->nama }}</td>
                                            <td>{{ $store->kotak_peluru == 1 ? 'Ya' : 'Tidak' }}</td>

                                            <td>
                                                <!-- Button trigger modal lihat barang-->
                                                <a class="text-dark" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#barang{{ $store->no_stpb }}">View</a>

                                                <!-- Modal barang-->
                                                <div class="modal fade" id="barang{{ $store->no_stpb }}" tabindex="-1"
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
                                                                    @if ($store->barang)
                                                                        @foreach (json_decode($store->barang) as $barang)
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}.</td>
                                                                                <td>{{ $barang->kodeBarang }}</td>
                                                                                <td class="text-end pe-4">
                                                                                    {{ number_format($barang->jumlahBarang) }}
                                                                                </td>
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
                                            @if ($store->status == 0)
                                                <td class="table-warning"> Menunggu Driver </td>
                                            @elseif ($store->status == 1)
                                                <td class="table-info">Dalam Perjalanan</td>
                                            @else
                                                <td class="table-success">
                                                    <a class="text-dark" href="/laporan/store/{{ $store->no_stpb }}"
                                                        role="button">Selesai</a>
                                                </td>
                                            @endif
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
                </div>
            @endcan
            @can('manajer')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card text-bg-primary">
                            <div class="card-header bg-primary text-light text-center fs-4">Pengiriman Hari Ini</div>
                            <div class="card-body">
                                <table
                                    class="displayTable table border table table-hover align-middle text-capitalize text-center">
                                    <thead>
                                        <th>NO</th>
                                        <th>NO STPB</th>
                                        <th>Driver</th>
                                        <th>Toko</th>
                                        <th>Kopel</th>
                                        <th>Status</th>
                                    </thead>

                                    @if (!$pengirimans->isEmpty())
                                        @foreach ($pengirimans as $pengiriman)
                                            <tr>
                                                <td> {{ $loop->iteration }}.</td>
                                                <td>{{ $pengiriman->no_stpb }}</td>
                                                <td class="text-start">{{ $pengiriman->driver->nama }}</td>
                                                <td class="text-start">{{ $pengiriman->toko->kode_toko }}</td>
                                                <td>{{ $pengiriman->kotak_peluru == 1 ? 'Ya' : 'Tidak' }}</td>


                                                {{-- Status --}}
                                                @if ($pengiriman->status == 0)
                                                    <td class="table-warning">Pending </td>
                                                @elseif ($pengiriman->status == 1)
                                                    <td class="table-info">Dalam Perjalanan</td>
                                                @else
                                                    <td class="table-success">
                                                        <a class="text-dark"
                                                            href="{{ route('laporan.pengiriman.detail', $pengiriman->no_stpb) }}"
                                                            role="button">Selesai</a>
                                                    </td>
                                                @endif
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
                    </div>
                    <div class="col-lg-6">
                        <div class="card text-bg-primary">
                            <div class="card-header bg-primary text-light text-center fs-4">Jumlah Pengiriman
                                {{ $tahun }}
                            </div>
                            <div class="card-body">
                                <div>
                                    <canvas id="chartPengiriman"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            @endsection

            @section('chart')
                <script>
                    var jumlah = @json($chartPengiriman);
                    var pengiriman = document.getElementById("chartPengiriman");
                    var BarChart = new Chart(pengiriman, {
                        type: 'bar',
                        data: {
                            labels: [
                                'Januari',
                                'Februari',
                                'Maret',
                                'April',
                                'Mei',
                                'Juni',
                                'Juli',
                                'Agustus',
                                'September',
                                'Oktober',
                                'November',
                                'Desember'
                            ],
                            datasets: [{
                                label: 'Jumlah Pengiriman',
                                backgroundColor: 'rgb(13, 110, 253)',
                                borderColor: 'rgb(13, 110, 253)',
                                data: jumlah,
                            }],
                        },
                        options: {
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                </script>
            @endsection
            @section('datatable')
                {{-- Table Pengiriman --}}
                <script>
                    $(document).ready(function() {

                        $.fn.dataTable.moment('D/M/YYYY');
                        $('table.displayTable').DataTable({
                            scrollY: '50vh',
                            scrollCollapse: true,
                        });
                    });
                </script>
            @endsection
