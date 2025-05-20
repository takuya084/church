<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>あなたの投稿にコメントがありました</title>
</head>
<body>
    ーーーー
    <p>コメント：{{$inputs['body']}}</p>
    ーーーー
    <p>コメントに返信するには、サイトにログインして<a href="{{route('post.show', $post)}}">こちら</a>の投稿をご覧ください。</p>
</body>
</html>