<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>市原集会所公式ホームページ | Ichihara Church Official Website</title>
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
            <small>SDAキリスト教会</small>
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

  <!-- ヒーロー -->
  <section class="hero" style="background: url('{{ asset('images/hero-bg.jpg') }}') no-repeat center/cover;">
    <div class="container">
      <h2>
        毎週土曜日 9時半～12時
      </h2>
      <p>
        お気軽にお越しください！
      </p>
    </div>
  </section>

  <!-- 特徴 -->
  <section class="features" id="features">
    <div class="container">
      <h2>
        礼拝日スケジュール<br>
        <small class="en-text-g">Worship Schedule</small>
      </h2>
      <div class="feature-cards">
        <div class="card">
          <img src="{{ asset('images/player.png') }}" alt="安息日学校" class="card-icon">
          <h3>
            1. 安息日学校<br>
            <small class="en-text-g">Sabbath School</small>
          </h3>
          <p>9:30 AM – 11:00 AM</p>
          <p>
            讃美歌とお祈りで始まり、教課（今週のテーマ）に沿って参加者同士で感想や質問をシェアします。<br>
            <small class="en-text-g">We begin with hymns and prayers, then participants share their impressions and questions based on this week's lesson theme.</small>
          </p>
        </div>
        <div class="card">
          <img src="{{ asset('images/bible.png') }}" alt="礼拝" class="card-icon">
          <h3>
            2. 礼拝<br>
            <small class="en-text-g">Worship Service</small>
          </h3>
          <p>11:00 AM – 12:00 PM</p>
          <p>
            祈りと賛美と牧師による聖書のメッセージを通じて礼拝を行っています。<br>
            <small class="en-text-g">Join us for worship with prayer, praise, and a Bible message delivered by our pastor.</small>
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- アクセス -->
  <section class="cta" id="contact">
    <div class="container">
      <h2>
        アクセス<br>
        <small class="en-text-w">Access</small>
      </h2>
      <p>
        市原市民会館2階、第3会議室です。<br>
        <small class="en-text-w">2nd Floor, Ichihara Civic Hall, Meeting Room 3.</small>
      </p>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3248.499247944447!2d140.1044929!3d35.4919315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x602299efd73ebfb5%3A0x6d48b181682533c5!2zU0RB5biC5Y6f6ZuG5Lya5omA!5e0!3m2!1sja!2sjp!4v1747109758026!5m2!1sja!2sjp"
        width="100%" height="450" style="border:0;" allowfullscreen loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
    <div class="container">
      <p>
        ご質問等あれば、お気軽にご連絡ください。<br>
        <small class="en-text-w">If you have any questions, feel free to contact us.</small>
      </p>
      <a href="{{ route('contact.create') }}" class="btn-cta">
        連絡フォームへ
      </a>
    </div>
  </section>

  <!-- フッター -->
  <footer class="site-footer">
    <small>&copy; 2025 市原集会所</small>
  </footer>

  

</body>

</html>
