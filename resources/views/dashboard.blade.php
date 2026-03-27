<x-layouts.app :title="__('Dashboard')">
    <div class="flex items-center justify-center min-h-[60vh] px-4">
        <div class="text-center max-w-lg">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800/30 dark:to-gray-700/30 mb-6">
                <svg class="w-10 h-10 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-neutral-800 dark:text-neutral-100 mb-2">
                ようこそ、{{ auth()->user()->name }}さん
            </h1>
            <p class="text-neutral-500 dark:text-neutral-400 mb-8">
                @if(auth()->user()->isGuest())
                    礼拝メッセージの閲覧・コメントができます
                @else
                    礼拝メッセージの閲覧・投稿ができます
                @endif
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('post.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gray-700 hover:bg-gray-800 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    投稿一覧を見る
                </a>
                @if(!auth()->user()->isGuest())
                    <a href="{{ route('post.create') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-700 text-neutral-700 dark:text-neutral-300 text-sm font-semibold rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-md transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        新しく投稿する
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
