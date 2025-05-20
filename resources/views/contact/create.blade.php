<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        市原集会所公式ホームページ<br>
        <small class="en-title">Ichihara Church Official Website</small>
    </title>
    @vite(['resources/css/style.css'])
</head>

<body>

    <!-- ヘッダー -->
    <header class="site-header">
        <div class="container header-inner">
            <div class="branding">
                <img src="{{ asset('logo/sda.png') }}" alt="SDA Logo">
                <div class="inner-title">
                    <h1 class="site-title">
                        市原集会所
                    </h1>
                    <p>
                        SDAキリスト教会</small>
                    </p>
                </div>
            </div>
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
                {{-- バリデーションエラーがある場合はここに表示 --}}
                <x-message :message="session('message')" />

                <form method="post" action="{{ route('contact.store') }}" enctype="multipart/form-data"
                    class="contact-form">
                    @csrf

                    <div class="form-group">
                        <label for="title" class="form-group__label">件名</label>
                        <input type="text" id="title" name="title" class="form-group__input"
                            placeholder="Enter Title" value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label for="body" class="form-group__label">本文</label>
                        <textarea id="body" name="body" class="form-group__textarea" rows="6">{{ old('body') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-group__label">メールアドレス</label>
                        <input type="email" id="email" name="email" class="form-group__input"
                            placeholder="Enter Email" value="{{ old('email') }}">
                    </div>

                    <button type="submit" class="btn btn-cta btn-large">
                        送信する
                    </button>
                </form>
            </div>
        </div>
    </section>


    <!-- フッター -->
    <footer class="site-footer">
        <small>&copy; 2025 市原集会所</small>
    </footer>

</body>

</html>
