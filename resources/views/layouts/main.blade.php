<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lawson</title>
    <link rel="shortcut icon" href="/favicon.ico" />

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <!-- Custom styles for this template -->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    {{-- <link href="/css/sidebars.css" rel="stylesheet"> --}}

    <link href="/css/styles.css" rel="stylesheet">

    {{-- DataTable --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">

    {{-- Chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="sb-nav-fixed fade-in">
    @include('layouts.navbar')
    <div id="layoutSidenav">
        @include('layouts.sidebar')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-4">
                    <div class="shadow">
                        @if (session()->has('success'))
                            <div class="alert alert-success text-center fs-5" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session()->has('failed'))
                            <div class="alert alert-danger text-center fs-5" role="alert">
                                {{ session('failed') }}
                            </div>
                        @endif
                    </div>
                    @if (Request::is(
                        'toko/*',
                        'barang/*',
                        'jalur*',
                        'pengiriman/create/proses',
                        'laporan/pengiriman',
                        'laporan/pengiriman/*',
                        'laporan/store',
                        'laporan/store/*',
                        'driver/*',
                        'pengiriman/create/barang') ||
                        (Request::is('laporan/driver') && Request::isMethod('get')))
                        @yield('container')
                    @else
                        <div class="bg-light px-3 py-2 shadow">
                            @yield('container')
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
        integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>



    {{-- DataTables --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.12.1/sorting/datetime-moment.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    @yield('chart')
    @yield('datatable')
</body>

</html>
