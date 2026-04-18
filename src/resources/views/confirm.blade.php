@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm">

  <h2 class="confirm__title">Confirm</h2>

  <table class="confirm-table">
    <tr>
      <th>お名前</th>
      <td>{{ $request->last_name }} {{ $request->first_name }}</td>
    </tr>

    <tr>
      <th>性別</th>
      <td>
        @if($request->gender == 1)
          男性
        @elseif($request->gender == 2)
          女性
        @else
          その他
        @endif
      </td>
    </tr>

    <tr>
      <th>メールアドレス</th>
      <td>{{ $request->email }}</td>
    </tr>

    <tr>
      <th>電話番号</th>
      <td>{{ $request->tel1 }}{{ $request->tel2 }}{{ $request->tel3 }}</td>
    </tr>

    <tr>
      <th>住所</th>
      <td>{{ $request->address }}</td>
    </tr>

    <tr>
      <th>建物名</th>
      <td>{{ $request->building }}</td>
    </tr>

    <tr>
      <th>お問い合わせの種類</th>
      <td>
        @foreach($categories as $category)
          @if($category->id == $request->category_id)
            {{ $category->content }}
          @endif
        @endforeach
      </td>
    </tr>

    <tr>
      <th>お問い合わせ内容</th>
      <td class="detail">{{ $request->detail }}</td>
    </tr>
  </table>

  <div class="confirm__button">

  <!-- 送信 -->
  <form action="/thanks" method="post">
    @csrf
    @foreach($request->except('_token') as $key => $value)
      <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <button type="submit" class="btn-send">送信</button>
  </form>

  <!-- 修正 -->
  <form action="/back" method="post">
    @csrf
    @foreach($request->except('_token') as $key => $value)
      <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <button type="submit" class="btn-fix">修正</button>
  </form>

</div>

</div>
@endsection