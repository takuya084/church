<?php

namespace App\Http\Controllers;

use App\Models\Pastor;
use App\Models\Post;
use App\Support\YouTube;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 最新の投稿は「今週の礼拝」として1ページ目に大きく表示する
        $latest = Post::with(['pastor', 'user', 'youtubeUrls'])
            ->orderBy('created_at', 'desc')
            ->first();

        $posts = Post::with(['pastor', 'user', 'comments'])
            ->when($latest, fn ($query) => $query->where('id', '!=', $latest->id))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $latestThumbnail = $latest
            ? YouTube::thumbnail($latest->youtubeUrls->first()?->youtube_url)
            : null;

        return view('post.index', compact('posts', 'latest', 'latestThumbnail'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->isGuest()) {
            abort(403);
        }

        $pastors = Pastor::orderBy('name')->get();
        return view('post.create', compact('pastors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->isGuest()) {
            abort(403);
        }

        $request->validate([
            'title'            => 'required|string|max:255',
            'pastor_id'        => 'nullable|exists:pastors,id',
            'bible_passage'    => 'nullable|string|max:255',
            'youtube_urls.*'   => ['nullable', 'url', self::youtubeUrlRule()],
        ]);
        $post = new Post();
        $post->title = $request->title;
        $post->pastor_id = $request->pastor_id;
        $post->bible_passage = $request->bible_passage;
        $post->user_id = auth()->user()->id;

        $post->save();

        // YouTube URL の保存（どの形式のURLでも埋め込み用に変換して保存）
        foreach ($request->youtube_urls ?? [] as $url) {
            if ($url) {
                $post->youtubeUrls()->create([
                    'youtube_url' => YouTube::embedUrl($url),
                ]);
            }
        }

        return redirect()->route('post.index')->with('message', '投稿を作成しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        $pastors = Pastor::orderBy('name')->get();
        return view('post.edit', compact('post', 'pastors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);
        $inputs = $request->validate([
            'title'            => 'required|string|max:255',
            'pastor_id'        => 'nullable|exists:pastors,id',
            'bible_passage'    => 'nullable|string|max:255',
            'body'             => 'nullable|string',
            'youtube_urls.*'   => ['nullable', 'url', self::youtubeUrlRule()],
        ]);

        $post->title = $inputs['title'];
        $post->pastor_id = $inputs['pastor_id'] ?? null;
        $post->bible_passage = $inputs['bible_passage'] ?? null;
        $post->body = $inputs['body'] ?? null;

        $post->save();

        //    既存レコードを一旦削除してから再登録
        $post->youtubeUrls()->delete();
        foreach ($inputs['youtube_urls'] ?? [] as $url) {
            if ($url) {
                $post->youtubeUrls()->create([
                    'youtube_url' => YouTube::embedUrl($url),
                ]);
            }
        }

        return redirect()->route('post.show', $post)->with('message', '投稿を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);
        $post->delete();
        return redirect()->route('post.index')->with('message', '投稿を削除しました');
    }

    /**
     * 入力されたYouTube URLから動画タイトルを返す（説教題の自動入力用）
     */
    public function youtubeTitle(Request $request)
    {
        if (auth()->user()->isGuest()) {
            abort(403);
        }

        return response()->json([
            'title' => YouTube::title($request->query('url')),
        ]);
    }

    private static function youtubeUrlRule(): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail) {
            if ($value && !YouTube::videoId($value)) {
                $fail('YouTubeの動画URLを入力してください。');
            }
        };
    }
}
