<x-layouts.app>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-neutral-100 dark:border-neutral-700 overflow-hidden">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-gray-700 to-gray-600 px-6 py-5">
                <h2 class="text-lg font-bold text-white tracking-wide">投稿の編集</h2>
                <p class="text-sm text-gray-300 mt-1">内容を変更して送信してください</p>
            </div>

            <div class="p-6 sm:p-8">
                {{-- メッセージ --}}
                <x-message :message="$errors->all()" type="error" />
                <x-message :message="session('message')" type="success" />

                <form method="post" action="{{ route('post.update', $post) }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    {{-- 説教題 --}}
                    <div>
                        <label for="title" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">説教題</label>
                        <input type="text" name="title" id="title"
                               class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition-all duration-200"
                               value="{{ old('title', $post->title) }}">
                    </div>

                    {{-- 牧師名（プルダウン） --}}
                    <div>
                        <label for="pastor_id" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">牧師名</label>
                        <select name="pastor_id" id="pastor_id"
                                class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition-all duration-200">
                            <option value="">-- 選択してください --</option>
                            @foreach ($pastors as $pastor)
                                <option value="{{ $pastor->id }}" @selected(old('pastor_id', $post->pastor_id) == $pastor->id)>
                                    {{ $pastor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 聖書朗読箇所 --}}
                    <div>
                        <label for="bible_passage" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">聖書朗読箇所</label>
                        <input type="text" name="bible_passage" id="bible_passage"
                               class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition-all duration-200"
                               placeholder="例：ヨハネ 3:16-18"
                               value="{{ old('bible_passage', $post->bible_passage) }}">
                    </div>

                    {{-- コメント --}}
                    <div>
                        <label for="body" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">コメント</label>
                        <textarea name="body" id="body" rows="5"
                                  class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition-all duration-200"
                                  placeholder="コメントを入力してください">{{ old('body', $post->body) }}</textarea>
                    </div>

                    {{-- YouTube URL --}}
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">YouTube 動画 URL</label>
                        <div id="youtube-urls-wrapper" class="space-y-2">
                            @php
                                $urlList = old('youtube_urls', $post->youtubeUrls->pluck('youtube_url')->toArray());
                            @endphp
                            @foreach ($urlList as $i => $url)
                                <div class="youtube-url-row flex items-center gap-2" data-index="{{ $i }}">
                                    <div class="flex flex-col gap-0.5">
                                        <button type="button" onclick="moveUrl(this, -1)" title="上へ"
                                                class="p-0.5 text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200 transition-colors disabled:opacity-30">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                            </svg>
                                        </button>
                                        <button type="button" onclick="moveUrl(this, 1)" title="下へ"
                                                class="p-0.5 text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200 transition-colors disabled:opacity-30">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="text" name="youtube_urls[]"
                                           placeholder="https://www.youtube.com/watch?v=…"
                                           class="flex-1 px-4 py-3 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition-all duration-200"
                                           value="{{ $url }}">
                                    <button type="button" onclick="removeUrl(this)" title="削除"
                                            class="p-2 text-neutral-400 hover:text-red-500 transition-colors rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-url"
                                class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            URL を追加
                        </button>
                    </div>

                    {{-- Submit --}}
                    <flux:button variant="primary" type="submit" class="w-full !py-3 !rounded-xl !text-sm !font-semibold">
                        送信する
                    </flux:button>
                </form>
            </div>
        </div>
    </div>

    @include('post._youtube-url-script')
</x-layouts.app>
