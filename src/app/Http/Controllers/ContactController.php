<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    public function confirm(Request $request)
    {
        $request->validate(
            [
                'last_name' => ['required'],
                'first_name' => ['required'],
                'gender' => ['required'],
                'email' => ['required', 'email'],
                'tel1' => ['required', 'regex:/^[A-Za-z0-9]+$/', 'max:5'],
                'tel2' => ['required', 'regex:/^[A-Za-z0-9]+$/', 'max:5'],
                'tel3' => ['required', 'regex:/^[A-Za-z0-9]+$/', 'max:5'],
                'address' => ['required'],
                'category_id' => ['required'],
                'detail' => ['required', 'max:120'],
            ],
            [
                'last_name.required' => '姓を入力してください',
                'first_name.required' => '名を入力してください',
                'gender.required' => '性別を選択してください',
                'email.required' => 'メールアドレスを入力してください',
                'email.email' => 'メールアドレスはメール形式で入力してください',
                'tel1.required' => '電話番号を入力してください',
                'tel2.required' => '電話番号を入力してください',
                'tel3.required' => '電話番号を入力してください',
                'tel1.regex' => '電話番号は 半角英数字で入力してください',
                'tel2.regex' => '電話番号は 半角英数字で入力してください',
                'tel3.regex' => '電話番号は 半角英数字で入力してください',
                'tel1.max' => '電話番号は 5桁まで数字で入力してください',
                'tel2.max' => '電話番号は 5桁まで数字で入力してください',
                'tel3.max' => '電話番号は 5桁まで数字で入力してください',
                'address.required' => '住所を入力してください',
                'category_id.required' => 'お問い合わせの種類を選択してください',
                'detail.required' => 'お問い合わせ内容を入力してください',
                'detail.max' => 'お問い合わせ内容は120文字以内で入力してください',
            ]
        );

        $categories = Category::all();
        return view('confirm', compact('request', 'categories'));
    }

    public function back(Request $request)
    {
        return redirect('/')->withInput($request->except('_token'));
    }

    public function store(Request $request)
    {
        Contact::create([
            'category_id' => $request->category_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'tel' => $request->tel1 . '-' . $request->tel2 . '-' . $request->tel3,
            'address' => $request->address,
            'building' => $request->building,
            'detail' => $request->detail,
        ]);

        return view('thanks');
    }
}