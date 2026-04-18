@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="contact">
    <h2 class="contact__title">Contact</h2>

    <form action="/confirm" method="post">
        @csrf

        <!-- お名前 -->
        <div class="form__group">
            <label>お名前 <span class="required">※</span></label>

            <div class="form__input">
                <div class="form__name">
                    <div>
                        <input type="text" name="last_name" placeholder="例: 山田" value="{{ old('last_name') }}">
                        <p class="error">@error('last_name'){{ $message }}@enderror</p>
                    </div>

                    <div>
                        <input type="text" name="first_name" placeholder="例: 太郎" value="{{ old('first_name') }}">
                        <p class="error">@error('first_name'){{ $message }}@enderror</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 性別 -->
        <div class="form__group">
            <label>性別 <span class="required">※</span></label>

            <div class="form__input">
                <div class="gender">
                    <label><input type="radio" name="gender" value="1" {{ old('gender') == '1' ? 'checked' : '' }}> 男性</label>
                    <label><input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }}> 女性</label>
                    <label><input type="radio" name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }}> その他</label>
                </div>
                <p class="error">@error('gender'){{ $message }}@enderror</p>
            </div>
        </div>

        <!-- メールアドレス -->
        <div class="form__group">
            <label>メールアドレス <span class="required">※</span></label>

            <div class="form__input">
                <input type="email" name="email" placeholder="例: test@example.com" value="{{ old('email') }}">
                <p class="error">@error('email'){{ $message }}@enderror</p>
            </div>
        </div>

        <!-- 電話番号 -->
        <div class="form__group">
            <label>電話番号 <span class="required">※</span></label>

            <div class="form__input">
                <div class="form__tel">
                    <input type="text" name="tel1" placeholder="080" value="{{ old('tel1') }}">
                    <span>-</span>
                    <input type="text" name="tel2" placeholder="1234" value="{{ old('tel2') }}">
                    <span>-</span>
                    <input type="text" name="tel3" placeholder="5678" value="{{ old('tel3') }}">
                </div>
                <p class="error">
                    @error('tel1'){{ $message }}@enderror
                    @if(!$errors->has('tel1'))
                        @error('tel2'){{ $message }}@enderror
                    @endif
                    @if(!$errors->has('tel1') && !$errors->has('tel2'))
                        @error('tel3'){{ $message }}@enderror
                    @endif
                </p>
            </div>
        </div>

        <!-- 住所 -->
        <div class="form__group">
            <label>住所 <span class="required">※</span></label>

            <div class="form__input">
                <input type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}">
                <p class="error">@error('address'){{ $message }}@enderror</p>
            </div>
        </div>

        <!-- 建物名 -->
        <div class="form__group">
            <label>建物名</label>

            <div class="form__input">
                <input type="text" name="building" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building') }}">
                <p class="error"></p>
            </div>
        </div>

        <!-- お問い合わせの種類 -->
        <div class="form__group">
            <label>お問い合わせの種類 <span class="required">※</span></label>

            <div class="form__input">
                <select name="category_id">
                    <option value="">選択してください</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->content }}
                        </option>
                    @endforeach
                </select>
                <p class="error">@error('category_id'){{ $message }}@enderror</p>
            </div>
        </div>

        <!-- お問い合わせ内容 -->
        <div class="form__group">
            <label>お問い合わせ内容 <span class="required">※</span></label>

            <div class="form__input">
                <textarea name="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                <p class="error">@error('detail'){{ $message }}@enderror</p>
            </div>
        </div>

        <div class="form__button">
            <button type="submit">確認画面</button>
        </div>
    </form>
</div>
@endsection