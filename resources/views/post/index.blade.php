<x-layouts.app>
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <x-message :message="session('message')" type="success" />

    <div class="space-y-4">
      @foreach ($posts as $post)
        <a href="{{ route('post.show', $post) }}"
           class="group block bg-white dark:bg-neutral-800 rounded-2xl p-5 sm:p-6 shadow-sm border border-neutral-100 dark:border-neutral-700 hover:shadow-lg hover:border-neutral-300 dark:hover:border-neutral-500 transition-all duration-300 hover:-translate-y-0.5">

          <div class="flex justify-between items-start gap-4">
            {{-- Left: title & details --}}
            <div class="flex-1 min-w-0">
              <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 group-hover:text-neutral-600 dark:group-hover:text-neutral-300 transition-colors duration-200 truncate">
                {{ $post->title }}
              </h3>

              {{-- 牧師名・聖書箇所 --}}
              @if($post->pastor || $post->pastor_name || $post->bible_passage)
                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1.5">
                  @if($post->pastor || $post->pastor_name)
                    <span class="inline-flex items-center text-xs text-neutral-500 dark:text-neutral-400">
                      <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0" />
                      </svg>
                      {{ $post->pastor->name ?? $post->pastor_name }}
                    </span>
                  @endif
                  @if($post->bible_passage)
                    <span class="inline-flex items-center text-xs text-neutral-500 dark:text-neutral-400">
                      <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                      </svg>
                      {{ $post->bible_passage }}
                    </span>
                  @endif
                </div>
              @endif

              <div class="flex items-center gap-3 mt-3">
                {{-- Author --}}
                <span class="inline-flex items-center text-xs text-neutral-400 dark:text-neutral-500">
                  <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0" />
                  </svg>
                  {{ $post->user->name ?? '退会ユーザー' }}
                </span>

                {{-- Date --}}
                <span class="inline-flex items-center text-xs text-neutral-400 dark:text-neutral-500">
                  <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>
                  {{ $post->created_at->diffForHumans() }}
                </span>

                {{-- Comment count --}}
                @if ($post->comments->count())
                  <span class="inline-flex items-center text-xs font-medium bg-neutral-100 dark:bg-neutral-700/30 text-neutral-600 dark:text-neutral-300 px-2 py-0.5 rounded-full">
                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H6l-4 4V5z"/>
                    </svg>
                    {{ $post->comments->count() }}
                  </span>
                @endif
              </div>
            </div>

            {{-- Right: arrow indicator --}}
            <div class="flex-shrink-0 mt-1">
              <svg class="w-5 h-5 text-neutral-300 dark:text-neutral-600 group-hover:text-neutral-500 transition-all duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
              </svg>
            </div>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</x-layouts.app>
