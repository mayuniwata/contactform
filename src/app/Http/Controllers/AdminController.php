<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::with('category')->paginate(7);
        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        $query = Contact::query()->with('category');

        if (!empty($request->keyword)) {
            $keyword = trim($request->keyword);
            $keywordNoSpace = str_replace([' ', '　'], '', $keyword);

            $query->where(function ($q) use ($keyword, $keywordNoSpace) {
                $q->where('last_name', 'like', '%' . $keyword . '%')
                  ->orWhere('first_name', 'like', '%' . $keyword . '%')
                  ->orWhere('email', 'like', '%' . $keyword . '%')
                  ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ['%' . $keywordNoSpace . '%'])
                  ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ['%' . $keyword . '%'])
                  ->orWhereRaw("CONCAT(last_name, '　', first_name) LIKE ?", ['%' . $keyword . '%']);
            });
        }

        if (!empty($request->gender) && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        if (!empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        if (!empty($request->date)) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->paginate(7)->appends($request->all());
        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    public function reset()
    {
        return redirect('/admin');
    }

    public function destroy(Request $request)
    {
        Contact::find($request->id)?->delete();

        return redirect('/admin')->with('message', '削除しました');
    }

    public function export(Request $request): StreamedResponse
    {
        $query = Contact::query()->with('category');

        if (!empty($request->keyword)) {
            $keyword = trim($request->keyword);
            $keywordNoSpace = str_replace([' ', '　'], '', $keyword);

            $query->where(function ($q) use ($keyword, $keywordNoSpace) {
                $q->where('last_name', 'like', '%' . $keyword . '%')
                  ->orWhere('first_name', 'like', '%' . $keyword . '%')
                  ->orWhere('email', 'like', '%' . $keyword . '%')
                  ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ['%' . $keywordNoSpace . '%'])
                  ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ['%' . $keyword . '%'])
                  ->orWhereRaw("CONCAT(last_name, '　', first_name) LIKE ?", ['%' . $keyword . '%']);
            });
        }

        if (!empty($request->gender) && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        if (!empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        if (!empty($request->date)) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->get();

        $response = new StreamedResponse(function () use ($contacts) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'お名前',
                '性別',
                'メールアドレス',
                '電話番号',
                '住所',
                '建物名',
                'お問い合わせの種類',
                'お問い合わせ内容',
                '作成日',
            ]);

            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->last_name . ' ' . $contact->first_name,
                    $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
                    $contact->email,
                    str_replace('-', '', $contact->tel),
                    $contact->address,
                    $contact->building,
                    optional($contact->category)->content,
                    $contact->detail,
                    $contact->created_at,
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="contacts.csv"');

        return $response;
    }
}