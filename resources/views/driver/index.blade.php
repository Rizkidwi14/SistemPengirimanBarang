@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col">
            <h1>Data Driver</h1>
            <a href="/driver/create" class="btn btn-primary">Tambah Driver</a>
        </div>
    </div>
    <div class="row table-responsive mt-2 pt-1">
        <table id="table" class="table border table-striped table-sm table-hover align-middle text-center ">
            <thead>
                <th>NO</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>email</th>
                <th>No Telepon</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($drivers as $driver)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-uppercase ">{{ $driver->nik }}</td>
                        <td class="text-capitalize text-start">{{ $driver->nama }}</td>
                        <td class="text-start">{{ $driver->email }}</td>
                        <td class="text-start">{{ $driver->no_telepon }}</td>
                        <td>
                            <a href="/driver/{{ $driver->slug }}" class="btn btn-primary">Detail</a>
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
