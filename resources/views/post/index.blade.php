<x-layouts.app>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- ヘッダ --}}
    {{-- <h2 class="text-2xl font-semibold text-gray-800 mb-3">投稿一覧</h2> --}}
    <x-message :message="session('message')" type="success" />

    {{-- ノート風罫線 --}}
    <ul class="divide-y divide-gray-300">
      @foreach ($posts as $post)
        <li class="py-3">
          <a href="{{ route('post.show', $post) }}" class="block">

            {{-- タイトル＆メタ情報 --}}
            <div class="flex justify-between items-start mb-1">
              <h3 class="text-lg font-medium text-gray-900">
                {{ $post->title }}
              </h3>
              <div class="text-right space-y-0.5">
                <p class="text-xs text-gray-500">
                  {{ $post->user->name ?? '退会ユーザー' }}
                </p>
                <time class="text-xs text-gray-500">
                  {{ $post->created_at->diffForHumans() }}
                </time>
              </div>
            </div>

            {{-- 本文抜粋 --}}
            <p class="text-gray-600 text-sm mt-1">
              {{ Str::limit($post->body, 100, '...') }}
            </p>

            {{-- コメント数 --}}
            @if ($post->comments->count())
              <div class="mt-1">
                <span
                  class="inline-flex items-center text-xs font-semibold bg-green-800 text-white px-2 py-0.5 rounded-full"
                >
                  <svg xmlns="http://www.w3.org/2000/svg"
                       class="h-4 w-4 mr-1 text-white"
                       fill="currentColor"
                       viewBox="0 0 20 20">
                    <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H6l-4 4V5z"/>
                  </svg>
                  {{ $post->comments->count() }}件
                </span>
              </div>
            @endif

          </a>
        </li>
      @endforeach
    </ul>
  </div>
</x-layouts.app>
