<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pengiriman</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    {{-- DataTable --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <style type="text/css">
        .table-isi tr td,
        th {
            border: 1px solid #000000;
            font-size: 9pt;
            padding: 0.5em;
        }
    </style>
    <center>
        <h5>{{ $title }}</h5>
    </center>
    @if ($data['tanggalawal'] && $data['tanggalakhir'])
        <div class="col-6">
            <table class="mb-3 table">
                @if ($data['toko'])
                    <tr>
                        <td>Toko </td>
                        <td>:</td>
                        <td>{{ strtoupper($data['toko']) }}</td>
                    </tr>
                @endif
                <tr>
                    <td>Periode </td>
                    <td>:</td>
                    <td>{{ date('d/m/Y', strtotime($data['tanggalawal'])) }} -
                        {{ date('d/m/Y', strtotime($data['tanggalakhir'])) }}
                    </td>
                </tr>
            </table>
        </div>
    @endif
    <table class="table table-isi align-middle text-capitalize text-center mt-2">
        <thead style="background-color: #4f6475;"class="text-light">
            <tr class="align-middle" max-height="10px">
                <th rowspan="2">NO</th>
                <th rowspan="2">NO STPB</th>
                <th rowspan="2">Toko</th>
                <th rowspan="2">Driver</th>
                <th rowspan="2">Kopel</th>
                <th rowspan="2">Tanggal</th>
                <th colspan="2">Waktu</th>
                <th rowspan="2">Status</th>
            </tr>
            <tr>
                <th>Kirim</th>
                <th>Terima</th>
            </tr>
        </thead>

        @if (!$pengirimans->isEmpty())
            @foreach ($pengirimans as $pengiriman)
                <tr>
                    <td class="text-end"> {{ $loop->iteration }}.</td>
                    <td>{{ $pengiriman->no_stpb }}</td>
                    <td>{{ $pengiriman->toko->kode_toko }}</td>
                    <td class="text-start">{{ $pengiriman->driver->nama }}</td>

                    {{-- Kotak Peluru --}}
                    @if ($pengiriman->kotak_peluru == 1)
                        <td> Tidak </td>
                    @else
                        <td> Ya </td>
                    @endif

                    {{-- Tanggal --}}
                    <td>{{ date('d/m/Y', strtotime($pengiriman->tanggal)) }}</td>

                    {{-- Waktu Kirim --}}
                    <td width="75px">
                        {{ $pengiriman->waktu_kirim ? date('H:i', strtotime($pengiriman->waktu_kirim)) : '-' }}
                    </td>

                    {{-- Waktu Terima --}}
                    <td width="75px">
                        {{ $pengiriman->waktu_terima ? date('H:i', strtotime($pengiriman->waktu_terima)) : '-' }}
                    </td>

                    {{-- Status --}}
                    @if ($pengiriman->status == 0)
                        <td> Pending </td>
                    @elseif ($pengiriman->status == 1)
                        <td>Dalam Perjalanan</td>
                    @elseif ($pengiriman->status == 2)
                        <td>Selesai</td>
                    @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="12">--- Kosong ---</td>
            </tr>
        @endif
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        window.print();
    </script>

</html>
