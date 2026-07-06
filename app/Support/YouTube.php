<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

class YouTube
{
    /**
     * watch / youtu.be / shorts / live / embed のどの形式のURLからも動画IDを取り出す
     */
    public static function videoId(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        $patterns = [
            '~youtube\.com/watch\?[^#]*v=([\w-]{11})~',
            '~youtu\.be/([\w-]{11})~',
            '~youtube\.com/(?:embed|shorts|live)/([\w-]{11})~',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * 任意の形式のYouTube URLを埋め込み用URLに変換する
     */
    public static function embedUrl(?string $url): ?string
    {
        $id = self::videoId($url);

        return $id ? "https://www.youtube.com/embed/{$id}" : null;
    }

    /**
     * サムネイル画像のURLを返す
     */
    public static function thumbnail(?string $url): ?string
    {
        $id = self::videoId($url);

        return $id ? "https://img.youtube.com/vi/{$id}/hqdefault.jpg" : null;
    }

    /**
     * oEmbed APIで動画タイトルを取得する（APIキー不要）
     */
    public static function title(?string $url): ?string
    {
        $id = self::videoId($url);
        if (!$id) {
            return null;
        }

        try {
            $response = Http::timeout(5)->get('https://www.youtube.com/oembed', [
                'url' => "https://www.youtube.com/watch?v={$id}",
                'format' => 'json',
            ]);

            return $response->ok() ? ($response->json('title') ?: null) : null;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
