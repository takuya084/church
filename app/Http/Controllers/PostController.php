<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
// 追加
use Illuminate\Support\Facades\Gate;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $user = auth()->user();
        return view('post.index', compact('posts', 'user'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'body'             => 'required|string|max:1000',
            'image'            => 'nullable|image|max:1024',   // 画像は任意
            'youtube_urls.*'   => 'nullable|url',
        ]);
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->user()->id;

        if (request('image')) {
            // $nameを$originalに変更
            $original = request()->file('image')->getClientOriginalName();
            // 名前に日時追加
            $name = date('Ymd_His') . '_' . $original;
            request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }

        $post->save();

        // YouTube URL の保存
        foreach ($request->youtube_urls ?? [] as $url) {
            if ($url) {
                $post->youtubeUrls()->create([
                    'youtube_url' => $url,
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
        // Gate::authorize('post-owner', $post);
        Gate::authorize('update', $post);
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Gate::authorize('post-owner', $post);
        Gate::authorize('update', $post);
        $inputs = $request->validate([
            'title'            => 'required|string|max:255',
            'body'             => 'required|string|max:1000',
            'image'            => 'nullable|image|max:5120',
            'youtube_urls.*'   => 'nullable|url',
        ]);

        $post->title = $inputs['title'];
        $post->body = $inputs['body'];

        if (request('image')) {
            $original = request()->file('image')->getClientOriginalName();
            $name = date('Ymd_His') . '_' . $original;
            $file = request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }

        $post->save();

        //    既存レコードを一旦削除してから再登録
        $post->youtubeUrls()->delete();
        foreach ($inputs['youtube_urls'] ?? [] as $url) {
            if ($url) {
                $post->youtubeUrls()->create([
                    'youtube_url' => $url,
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
        // if (Gate::allows('post-owner', $post) || Gate::allows('admin', $post)) {
        //     $post->delete();
        //     return redirect()->route('post.index')->with('message', '投稿を削除しました');
        // } else {
        //     abort(403, 'Unauthorized action.');
        // }
        Gate::authorize('delete', $post);
        $post->delete();
        return redirect()->route('post.index')->with('message', '投稿を削除しました');
    }
}
