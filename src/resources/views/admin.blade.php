@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin">
    <h2 class="admin__title">Admin</h2>

    <form action="/search" method="get" class="search-form">
        <input
            type="text"
            name="keyword"
            class="search-form__keyword"
            placeholder="名前やメールアドレスを入力してください"
            value="{{ request('keyword') }}"
        >

        <select name="gender" class="search-form__select">
            <option value="">性別</option>
            <option value="all" {{ request('gender') == 'all' ? 'selected' : '' }}>全て</option>
            <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
            <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
            <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
        </select>

        <select name="category_id" class="search-form__select">
            <option value="">お問い合わせの種類</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->content }}
                </option>
            @endforeach
        </select>

        <input
            type="date"
            name="date"
            class="search-form__date"
            value="{{ request('date') }}"
        >

        <button type="submit" class="search-form__search-btn">検索</button>
        <a href="/reset" class="search-form__reset-btn">リセット</a>
    </form>

    <div class="admin__sub-area">
        <form action="/export" method="get">
            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
            <input type="hidden" name="gender" value="{{ request('gender') }}">
            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            <input type="hidden" name="date" value="{{ request('date') }}">
            <button type="submit" class="admin__export-btn">エクスポート</button>
        </form>

        <div class="admin__pagination">
            @if ($contacts->lastPage() > 1)

                @if ($contacts->currentPage() > 1)
                    <a href="{{ $contacts->appends(request()->query())->url($contacts->currentPage() - 1) }}" class="pagination__arrow">&lt;</a>
                @else
                    <span class="pagination__arrow pagination__arrow--disabled">&lt;</span>
                @endif

                @for ($i = 1; $i <= $contacts->lastPage(); $i++)
                    <a href="{{ $contacts->appends(request()->query())->url($i) }}"
                       class="pagination__link {{ $contacts->currentPage() == $i ? 'pagination__link--active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor

                @if ($contacts->currentPage() < $contacts->lastPage())
                    <a href="{{ $contacts->appends(request()->query())->url($contacts->currentPage() + 1) }}" class="pagination__arrow">&gt;</a>
                @else
                    <span class="pagination__arrow pagination__arrow--disabled">&gt;</span>
                @endif

            @endif
        </div>
    </div>

    <table class="admin-table">
        <thead>
    <tr>
        <th>お名前</th>
        <th>性別</th>
        <th>メールアドレス</th>
        <th>お問い合わせの種類</th>
        <th></th>
    </tr>
</thead>

<tbody>
@foreach($contacts as $contact)
<tr>
    <td>{{ $contact->last_name . ' ' . $contact->first_name }}</td>

    <td>
        {{ $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他') }}
    </td>

    <td>{{ $contact->email }}</td>

    <td>{{ optional($contact->category)->content }}</td>

    <td>
        <button type="button" class="detail-btn">詳細</button>
    </td>
</tr>
@endforeach
</tbody>
    </table>
</div>

<div id="modal" class="modal">
    <div class="modal__content">
        <button type="button" class="modal__close">&times;</button>

        <div class="modal__row">
            <span class="modal__label">お名前</span>
            <span class="modal__value" id="modal-name"></span>
        </div>

        <div class="modal__row">
            <span class="modal__label">性別</span>
            <span class="modal__value" id="modal-gender"></span>
        </div>

        <div class="modal__row">
            <span class="modal__label">メールアドレス</span>
            <span class="modal__value" id="modal-email"></span>
        </div>

        <div class="modal__row">
            <span class="modal__label">電話番号</span>
            <span class="modal__value" id="modal-tel"></span>
        </div>

        <div class="modal__row">
            <span class="modal__label">住所</span>
            <span class="modal__value" id="modal-address"></span>
        </div>

        <div class="modal__row">
            <span class="modal__label">建物名</span>
            <span class="modal__value" id="modal-building"></span>
        </div>

        <div class="modal__row">
            <span class="modal__label">お問い合わせの種類</span>
            <span class="modal__value" id="modal-category"></span>
        </div>

        <div class="modal__row">
            <span class="modal__label">お問い合わせ内容</span>
            <span class="modal__value" id="modal-detail"></span>
        </div>

        <form action="/delete" method="post">
            @csrf
            <input type="hidden" name="id" id="delete-id">
            <button type="submit" class="delete-btn">削除</button>
        </form>
    </div>
</div>

<script>
const modal = document.getElementById('modal');
const closeBtn = document.querySelector('.modal__close');
const buttons = document.querySelectorAll('.detail-btn');

buttons.forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('modal-name').textContent =
            btn.dataset.last + ' ' + btn.dataset.first;

        document.getElementById('modal-gender').textContent =
            btn.dataset.gender == 1 ? '男性' :
            btn.dataset.gender == 2 ? '女性' : 'その他';

        document.getElementById('modal-email').textContent = btn.dataset.email;
        document.getElementById('modal-tel').textContent = btn.dataset.tel;
        document.getElementById('modal-address').textContent = btn.dataset.address;
        document.getElementById('modal-building').textContent = btn.dataset.building;
        document.getElementById('modal-category').textContent = btn.dataset.category;
        document.getElementById('modal-detail').textContent = btn.dataset.detail;
        document.getElementById('delete-id').value = btn.dataset.id;

        modal.style.display = 'flex';
    });
});

closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});
</script>
@endsection