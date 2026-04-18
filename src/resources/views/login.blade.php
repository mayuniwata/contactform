@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login">
    <h2 class="login__title">Login</h2>

    <div class="login__card">
        <form action="/login" method="post">
            @csrf

            <div class="login__group">
                <label>メールアドレス</label>
                <input
                    type="email"
                    name="email"
                    placeholder="例: test@example.com"
                    value="{{ old('email') }}"
                >
                <p class="error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="login__group">
                <label>パスワード</label>
                <input
                    type="password"
                    name="password"
                    placeholder="例: coachtech1106"
                >
                <p class="error">
                    @error('password')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="login__btn">
                <button type="submit">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection