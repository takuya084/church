<x-layouts.app>
  <div class="py-8 sm:py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden shadow-sm border border-neutral-100 dark:border-neutral-700">

        {{-- Header bar --}}
        <div class="bg-gradient-to-r from-gray-700 to-gray-600 px-6 py-5">
          <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white tracking-wide">{{ $post->title }}</h1>
            <div class="flex items-center gap-2">
              @can('update', $post)
                <a href="{{ route('post.edit', $post) }}">
                  <flux:button size="sm" class="!bg-white/15 hover:!bg-white/25 !text-white !border-white/20 !text-xs">編集</flux:button>
                </a>
              @endcan
              @can('delete', $post)
                <form method="post" action="{{ route('post.destroy', $post) }}" class="inline">
                  @csrf @method('delete')
                  <flux:button
                    size="sm"
                    variant="danger"
                    class="!bg-red-500/80 hover:!bg-red-500 !text-white !text-xs"
                    onclick="return confirm('本当に削除しますか？')"
                  >
                    削除
                  </flux:button>
                </form>
              @endcan
            </div>
          </div>
          <div class="flex items-center gap-2 mt-2 text-sm text-gray-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0" />
            </svg>
            <span>{{ $post->user->name ?? '退会ユーザー' }}</span>
            <span class="opacity-50">|</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
            <span>{{ $post->created_at->format('Y年n月j日 H:i') }}</span>
          </div>
        </div>

        {{-- Content --}}
        <div class="px-6 py-8">

          {{-- 牧師名・聖書朗読箇所 --}}
          @if($post->pastor || $post->pastor_name || $post->bible_passage)
            <div class="flex flex-wrap gap-x-6 gap-y-2 mb-6">
              @if($post->pastor || $post->pastor_name)
                <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                  <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0" />
                  </svg>
                  <span class="text-xs text-neutral-400">牧師</span>
                  <span class="font-medium">{{ $post->pastor->name ?? $post->pastor_name }}</span>
                </div>
              @endif
              @if($post->bible_passage)
                <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                  <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                  </svg>
                  <span class="text-xs text-neutral-400">聖書箇所</span>
                  <span class="font-medium">{{ $post->bible_passage }}</span>
                </div>
              @endif
            </div>
          @endif

          {{-- 本文（既存データ用） --}}
          @if($post->body)
            <div class="text-neutral-700 dark:text-neutral-300 whitespace-pre-line leading-relaxed">{{ $post->body }}</div>
          @endif

          {{-- Image --}}
          @if($post->image)
            <div class="mt-8">
              <img
                src="{{ asset('storage/images/' . $post->image) }}"
                class="w-full rounded-xl shadow-sm"
                alt="投稿画像"
              >
            </div>
          @endif

          {{-- YouTube --}}
          @if($post->youtubeUrls->isNotEmpty())
            <div class="mt-10 space-y-6">
              <h2 class="text-base font-bold text-neutral-800 dark:text-neutral-200 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
                礼拝動画
              </h2>
              @foreach($post->youtubeUrls as $youtubeUrl)
                <div class="relative w-full rounded-xl overflow-hidden shadow-md" style="padding-top:56.25%;">
                  <iframe
                    src="{{ $youtubeUrl->youtube_url }}"
                    class="absolute top-0 left-0 w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                  ></iframe>
                </div>
              @endforeach
            </div>
          @endif
        </div>

        {{-- Comment section --}}
        <div class="border-t border-neutral-100 dark:border-neutral-700 px-6 py-8 bg-neutral-50/50 dark:bg-neutral-800/50">
          @livewire('comment-section', ['post' => $post])
        </div>
      </div>
    </div>
  </div>
</x-layouts.app>
