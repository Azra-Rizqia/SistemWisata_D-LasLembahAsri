@extends('layouts.loginCondition')

@section('content')
    <div class="main-content-blank-page">
        <div class="main-information-login">
            <div class="form-section-login">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="list-input-login">
                            <div class="headline-center">
                                <h1 class="font-h1">Selamat Datang</h1>
                                <p class="font-T3-Regular">Masuk dan mulai kelola D'las Lembah Asri</p>
                            </div>
                            <div class="input-item">
                                <label class="form-label">Email Anda</label>
                                <input type="email" name="email_admin" class="form-control"
                                    placeholder="Masukan email anda"
                                    value="{{ old('email_admin') }}" style="border-radius : 32px" minlength="8" maxlength="20" required>
                                @error('email_admin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="input-item">
                                <label class="form-label">Password Anda</label>
                                <input type="password" name="password_admin" class="form-control" placeholder="Masukan password anda"
                                    value="{{ old('password_admin') }}" style="border-radius : 32px" minlength="8" maxlength="20" required>
                                @error('password_admin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%">Login Sekarang</button>
                        </div>
                    </form>

            </div>
        </div>
        <div class="frame-image">
        </div>
    </div>
@endsection
