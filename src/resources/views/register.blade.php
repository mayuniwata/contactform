@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register">
    <h2 class="register__title">Register</h2>

    <div class="register__card">
        <form action="/register" method="post">
            @csrf

            <div class="register__group">
                <label>お名前</label>
                <input
                    type="text"
                    name="name"
                    placeholder="例: 山田　太郎"
                    value="{{ old('name') }}"
                >
                <p class="error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="register__group">
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

            <div class="register__group">
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

            <div class="register__btn">
                <button type="submit">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection