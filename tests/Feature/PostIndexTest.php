<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostIndexTest extends TestCase
{
    use RefreshDatabase;

    private function createPosts(int $count): void
    {
        $user = User::factory()->create();

        for ($i = 1; $i <= $count; $i++) {
            $post = Post::create([
                'title' => "礼拝メッセージ {$i}",
                'user_id' => $user->id,
            ]);
            // 作成日時をずらして並び順を確定させる
            $post->created_at = now()->subDays($count - $i);
            $post->save();
        }
    }

    public function test_latest_post_is_featured_on_first_page(): void
    {
        $this->createPosts(3);

        $response = $this->get('/post');

        $response->assertStatus(200);
        $response->assertSee('今週の礼拝');
        $response->assertSee('礼拝メッセージ 3');
    }

    public function test_post_list_is_paginated(): void
    {
        // 最新1件はフィーチャー表示、残り12件が10件ずつページ分割される
        $this->createPosts(13);

        $firstPage = $this->get('/post');
        $firstPage->assertStatus(200);
        $firstPage->assertSee('今週の礼拝');
        $firstPage->assertSee('礼拝メッセージ 12'); // 一覧の先頭
        $firstPage->assertDontSee('礼拝メッセージ 2'); // 2ページ目の内容

        $secondPage = $this->get('/post?page=2');
        $secondPage->assertStatus(200);
        $secondPage->assertDontSee('今週の礼拝'); // フィーチャーは1ページ目のみ
        $secondPage->assertSee('礼拝メッセージ 2');
        $secondPage->assertSee('礼拝メッセージ 1');
    }
}
