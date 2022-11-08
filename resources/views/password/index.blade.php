@extends('layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="alert alert-success mb-1 mt-3" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
        <h1 class="h2">{{ $title }}<h1>
    </div>

    <div class="row">
        <div class="col-lg-10">
            <form method="POST" action="/password" class="mb-5">
                @csrf

                {{-- Password Lama --}}
                <div class="mb-2">
                    <label for="password_lama" class="form-label">Password Lama</label>
                    <input type="password" name="password_lama" id="password_lama"
                        class="form-control @error('password_lama') is-invalid @enderror" autocomplete="off" required
                        autofocus>
                    @error('password_lama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div class="mb-2">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" autocomplete="off" required autofocus>
                    <input type="checkbox" onclick="showPassword()" tabindex="-1"> Show Password
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Konfirmasi password baru --}}
                <div class="mb-2">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="off"
                        required autofocus>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>


    <script>
        function showPassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
