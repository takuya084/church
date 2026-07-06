<x-layouts.app>
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <x-message :message="session('message')" type="success" />

    {{-- 今週の礼拝（最新の投稿・1ページ目のみ） --}}
    @if ($latest && $posts->onFirstPage())
      <a href="{{ route('post.show', $latest) }}"
         class="group block bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden shadow-md border border-neutral-100 dark:border-neutral-700 hover:shadow-xl hover:border-neutral-300 dark:hover:border-neutral-500 transition-all duration-300 hover:-translate-y-0.5 mb-10">

        {{-- サムネイル --}}
        <div class="relative bg-neutral-900" style="aspect-ratio: 16 / 9;">
          @if ($latestThumbnail)
            <img src="{{ $latestThumbnail }}" alt="{{ $latest->title }}"
                 class="absolute inset-0 w-full h-full object-cover">
          @endif
          <div class="absolute inset-0 bg-black/25 group-hover:bg-black/10 transition-colors duration-300"></div>
          {{-- 再生ボタン --}}
          <div class="absolute inset-0 flex items-center justify-center">
            <span class="flex items-center justify-center w-20 h-20 rounded-full bg-red-600 group-hover:bg-red-500 group-hover:scale-110 shadow-lg transition-all duration-300">
              <svg class="w-9 h-9 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5.14v13.72c0 .8.87 1.3 1.56.88l10.54-6.86a1.04 1.04 0 0 0 0-1.76L9.56 4.26A1.04 1.04 0 0 0 8 5.14Z"/>
              </svg>
            </span>
          </div>
          {{-- バッジ --}}
          <span class="absolute top-4 left-4 inline-flex items-center gap-1.5 bg-red-600 text-white text-sm font-bold px-4 py-1.5 rounded-full shadow">
            今週の礼拝
          </span>
        </div>

        <div class="p-6 sm:p-8">
          <p class="text-base text-neutral-500 dark:text-neutral-400 mb-2">
            {{ $latest->created_at->isoFormat('YYYY年M月D日(ddd)') }}
          </p>
          <h2 class="text-2xl sm:text-3xl font-bold text-neutral-900 dark:text-neutral-100 leading-snug">
            {{ $latest->title }}
          </h2>
          @if($latest->pastor || $latest->pastor_name || $latest->bible_passage)
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-4">
              @if($latest->pastor || $latest->pastor_name)
                <span class="inline-flex items-center text-base text-neutral-600 dark:text-neutral-300">
                  <svg class="w-5 h-5 mr-1.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0" />
                  </svg>
                  {{ $latest->pastor->name ?? $latest->pastor_name }}
                </span>
              @endif
              @if($latest->bible_passage)
                <span class="inline-flex items-center text-base text-neutral-600 dark:text-neutral-300">
                  <svg class="w-5 h-5 mr-1.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                  </svg>
                  {{ $latest->bible_passage }}
                </span>
              @endif
            </div>
          @endif
        </div>
      </a>

      @if ($posts->isNotEmpty())
        <h2 class="text-lg font-bold text-neutral-600 dark:text-neutral-300 mb-4">これまでの礼拝</h2>
      @endif
    @endif

    <div class="space-y-4">
      @foreach ($posts as $post)
        <a href="{{ route('post.show', $post) }}"
           class="group block bg-white dark:bg-neutral-800 rounded-2xl p-5 sm:p-6 shadow-sm border border-neutral-100 dark:border-neutral-700 hover:shadow-lg hover:border-neutral-300 dark:hover:border-neutral-500 transition-all duration-300 hover:-translate-y-0.5">

          <div class="flex justify-between items-center gap-4">
            {{-- Left: title & details --}}
            <div class="flex-1 min-w-0">
              {{-- Date --}}
              <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">
                {{ $post->created_at->isoFormat('YYYY年M月D日(ddd)') }}
              </p>

              <h3 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100 group-hover:text-neutral-600 dark:group-hover:text-neutral-300 transition-colors duration-200 leading-snug">
                {{ $post->title }}
              </h3>

              {{-- 牧師名・聖書箇所 --}}
              @if($post->pastor || $post->pastor_name || $post->bible_passage)
                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2">
                  @if($post->pastor || $post->pastor_name)
                    <span class="inline-flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0" />
                      </svg>
                      {{ $post->pastor->name ?? $post->pastor_name }}
                    </span>
                  @endif
                  @if($post->bible_passage)
                    <span class="inline-flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                      </svg>
                      {{ $post->bible_passage }}
                    </span>
                  @endif

                  {{-- Comment count --}}
                  @if ($post->comments->count())
                    <span class="inline-flex items-center text-sm font-medium bg-neutral-100 dark:bg-neutral-700/30 text-neutral-600 dark:text-neutral-300 px-2.5 py-0.5 rounded-full">
                      <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H6l-4 4V5z"/>
                      </svg>
                      {{ $post->comments->count() }}
                    </span>
                  @endif
                </div>
              @endif
            </div>

            {{-- Right: arrow indicator --}}
            <div class="flex-shrink-0">
              <svg class="w-6 h-6 text-neutral-300 dark:text-neutral-600 group-hover:text-neutral-500 transition-all duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
              </svg>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    {{-- ページネーション --}}
    @if ($posts->hasPages())
      <div class="mt-10">
        {{ $posts->onEachSide(1)->links() }}
      </div>
    @endif
  </div>
</x-layouts.app>
