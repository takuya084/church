<x-layouts.app>
  <div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">  {{-- 幅を制限して動画視聴に最適化 --}}
      <div class="bg-white rounded-2xl px-6 py-8 shadow-lg transition-shadow hover:shadow-2xl">

        {{-- ヘッダー --}}
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            {{-- <img
              src="{{ asset('storage/avatar/' . ($post->user->avatar ?? 'user_default.jpg')) }}"
              class="w-10 h-10 rounded-full object-cover"
            > --}}
            <h1 class="text-xl font-semibold text-gray-800">{{ $post->title }}</h1>
          </div>
          <div class="space-x-2">
            @can('update', $post)
              <a href="{{ route('post.edit', $post) }}">
                <flux:button size="sm" class="bg-teal-600 hover:bg-teal-700">編集</flux:button>
              </a>
            @endcan
            @can('delete', $post)
              <form method="post" action="{{ route('post.destroy', $post) }}" class="inline">
                @csrf @method('delete')
                <flux:button
                  size="sm"
                  variant="danger"
                  class="bg-red-600 hover:bg-red-700"
                  onclick="return confirm('本当に削除しますか？')"
                >
                  削除
                </flux:button>
              </form>
            @endcan
          </div>
        </div>

        <hr class="my-4">

        {{-- 本文 --}}
        <p class="text-gray-700 whitespace-pre-line">{{ $post->body }}</p>

        {{-- 画像 --}}
        @if($post->image)
          <div class="mt-6 text-center">
            <img
              src="{{ asset('storage/images/' . $post->image) }}"
              class="inline-block max-w-full h-auto rounded-md"
            >
          </div>
        @endif

        {{-- YouTube 動画 --}}
        @if($post->youtubeUrls->isNotEmpty())
          <div class="mt-8 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800">関連動画</h2>
            @foreach($post->youtubeUrls as $youtubeUrl)
              <div class="relative w-full" style="padding-top:56.25%;"> {{-- 16:9 --}}
                <iframe
                  src="{{ $youtubeUrl->youtube_url }}"
                  class="absolute top-0 left-0 w-full h-full rounded-md shadow"
                  frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen
                ></iframe>
              </div>
            @endforeach
          </div>
        @endif

        {{-- 投稿日時・ユーザー名 --}}
        <div class="mt-6 text-right text-sm text-gray-500">
          {{ $post->user->name ?? '退会ユーザー' }} • {{ $post->created_at->format('Y年n月j日 H:i') }}
        </div>

        {{-- コメントセクション --}}
        <div class="mt-8">
          @livewire('comment-section', ['post' => $post])
        </div>
      </div>
    </div>
  </div>
</x-layouts.app>
