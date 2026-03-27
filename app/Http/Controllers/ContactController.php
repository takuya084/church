<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {

        $inputs=request()->validate([
            'title'=>'required|max:255',
            'email'=>'required|email|max:255',
            'body'=>'required|max:1000',
        ]);
        
        Contact::create($inputs);

        try {
            Mail::to(config('mail.admin'))->send(new ContactForm($inputs));
            Mail::to($inputs['email'])->send(new ContactForm($inputs));
        } catch (\Exception $e) {
            Log::error('連絡フォームのメール送信に失敗しました: ' . $e->getMessage());
            return back()->with('message', 'お問い合わせを受け付けました。メール送信に問題がありましたが、内容は保存されています。');
        }

        return back()->with('message', 'メールを送信したのでご確認ください');
    }

}
