@extends('layouts.main')

@section('container')
    <div class="col-6 bg-light px-3 py-2 shadow">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
            <h1 class="h2">Tambah Data Driver<h1>
        </div>

        <div class="col-md">
            <form method="POST" action="/driver" enctype="multipart/form-data">
                @csrf

                {{-- Nama --}}
                <div class="mb-2">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama"
                        class="form-control text-capitalize @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                        autocomplete="off" required autofocus>
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <input type="hidden" name="slug" id="slug"
                        class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}"
                        autocomplete="off" required>
                </div>

                {{-- NIK --}}
                <div class="mb-2">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="number" name="nik" id="nik" min="1"
                        class="form-control text-uppercase @error('nik') is-invalid @enderror" value="{{ old('nik') }}"
                        required autocomplete="off"
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength="10">
                    @error('nik')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- email --}}
                <div class="mb-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                        autocomplete="off" required>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div class="mb-2">
                    <label for="no_telepon" class="form-label">Nomor Telepon</label>
                    <input type="number" name="no_telepon" id="no_telepon" pattern="[0-9]" min="1"
                        class="form-control text-uppercase @error('no_telepon') is-invalid @enderror"
                        value="{{ old('no_telepon') }}" autocomplete="off" required
                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength="13">

                    @error('no_telepon')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Foto --}}
                <div class="mb-3">
                    <label for="foto" class="form-label @error('foto') is-invalid @enderror">Foto</label>
                    <img class="img-preview img-fluid mb-3 col-sm-6" style="max-width: 300px">
                    <input class="form-control" type="file" name="foto" id="foto" onchange="previewImage()">
                    @error('foto')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mb-1">Tambah Driver</button>
            </form>
        </div>
    </div>


    <script>
        const nama = document.querySelector('#nama');
        const slug = document.querySelector('#slug');

        nama.addEventListener('change', function() {
            fetch('/driver/checkSlug?nama=' + nama.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });

        function previewImage() {
            const foto = document.querySelector('#foto');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(foto.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
