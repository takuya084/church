<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ | 市原集会所</title>
    @vite(['resources/css/style.css'])
</head>

<body>

    <!-- ヘッダー -->
    <header class="site-header">
        <div class="container header-inner">
            <a href="{{ route('home') }}" class="branding">
                <img src="{{ asset('logo/sda.png') }}" alt="SDA Logo">
                <div class="inner-title">
                    <h1 class="site-title">市原集会所</h1>
                    <p><small style="font-size:12px; opacity:0.75; font-weight:400;">SDAキリスト教会</small></p>
                </div>
            </a>
            <nav>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">一覧へ</a>
                    @else
                        <a href="{{ route('login') }}">ログイン</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">新規登録</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>


    <section id="contact">
        <div class="container">
            <div class="form-box">
                <h2 class="form-box__title">お問い合わせ</h2>
                <x-message :message="session('message')" />

                <form method="post" action="{{ route('contact.store') }}" class="contact-form">
                    @csrf

                    <div class="form-group">
                        <label for="title" class="form-group__label">件名</label>
                        <input type="text" id="title" name="title" class="form-group__input"
                            placeholder="件名を入力してください" value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label for="body" class="form-group__label">本文</label>
                        <textarea id="body" name="body" class="form-group__textarea" rows="6"
                            placeholder="お問い合わせ内容を入力してください">{{ old('body') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-group__label">メールアドレス</label>
                        <input type="email" id="email" name="email" class="form-group__input"
                            placeholder="example@email.com" value="{{ old('email') }}">
                    </div>

                    <button type="submit" class="btn btn-cta contact-form__btn">
                        送信する
                    </button>
                </form>
            </div>
        </div>
    </section>


    <!-- フッター -->
    <footer class="site-footer">
        <small>&copy; {{ date('Y') }} 市原集会所</small>
    </footer>

</body>

</html>
