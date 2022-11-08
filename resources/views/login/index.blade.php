@extends('layouts.mainLogin')

@section('container')
    <main class="form-signin">
        <img class="mb-2" src="/image/logo.svg" width="300" height="200">
        <h1 class="h3 mb-3 fw-normal text-center">Login</h1>

        @if (session()->has('loginError'))
            <div class="alert alert-danger" role="alert">
                {{ session('loginError') }}
            </div>
        @endif

        <form action="/login" method="post">
            @csrf
            <div class="form-floating">
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                    id="username" autocomplete="off" placeholder="Username" autofocus>
                <label for="username">Username</label>
                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    id="password" placeholder="Password">
                <label for="password">Password</label>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button class="w-100 mt-2 btn btn-lg btn-primary" type="submit">Login</button>
        </form>
    </main>
@endsection
