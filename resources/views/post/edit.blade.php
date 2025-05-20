<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                投稿の編集画面
            </h2>

            {{-- メッセージ表示用 --}}
            <x-message :message="$errors->all()" type="error" />
            <x-message :message="session('message')" type="success" />

            <form method="post" action="{{ route('post.update', $post) }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                {{-- 件名 --}}
                <div class="md:flex items-center mt-8">
                    <div class="w-full flex flex-col">
                        <label for="title" class="font-semibold leading-none mt-4">件名</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="w-auto py-2 pl-2 placeholder-gray-300 border border-gray-300 rounded-md"
                            value="{{ old('title', $post->title) }}"
                        >
                    </div>
                </div>

                {{-- 本文 --}}
                <div class="w-full flex flex-col">
                    <label for="body" class="font-semibold leading-none mt-4">本文</label>
                    <textarea
                        name="body"
                        id="body"
                        class="w-auto py-2 pl-2 border border-gray-300 rounded-md"
                        cols="30"
                        rows="10"
                    >{{ old('body', $post->body) }}</textarea>
                </div>

                {{-- 既存画像表示＆差し替え --}}
                <div class="w-full flex flex-col">
                    @if ($post->image)
                        <div>(画像ファイル：{{ $post->image }})</div>
                        <img
                            src="{{ asset('storage/images/' . $post->image) }}"
                            class="mx-auto my-4"
                            style="height:300px;"
                        >
                    @endif
                    <label for="image" class="font-semibold leading-none mt-4">画像</label>
                    <div>
                        <flux:input id="image" type="file" name="image" />
                    </div>
                </div>

                {{-- YouTube URL 編集 --}}
                <div class="w-full flex flex-col mt-6">
                    <label class="font-semibold leading-none">YouTube 動画 URL</label>
                    <div id="youtube-urls-wrapper" class="mt-2">
                        @php
                            $urlList = old('youtube_urls', $post->youtubeUrls->pluck('youtube_url')->toArray());
                        @endphp
                        @foreach ($urlList as $url)
                            <input
                                type="text"
                                name="youtube_urls[]"
                                placeholder="https://www.youtube.com/watch?v=…"
                                class="w-full py-2 pl-2 border border-gray-300 rounded-md mb-2"
                                value="{{ $url }}"
                            >
                        @endforeach
                    </div>
                    <button
                        type="button"
                        id="add-url"
                        class="mt-2 text-sm text-blue-600 hover:underline"
                    >
                        ＋ URL を追加
                    </button>
                </div>

                {{-- 送信ボタン --}}
                <flux:button variant="primary" type="submit" class="w-full mt-4">
                    送信する
                </flux:button>
            </form>
        </div>
    </div>

    <script>
        (function(){
            const btn     = document.getElementById('add-url');
            const wrapper = document.getElementById('youtube-urls-wrapper');
            if (!btn || !wrapper) {
                console.error('add-urlボタンまたはwrapperが見つかりません');
                return;
            }
            btn.addEventListener('click', function(){
                const input = document.createElement('input');
                input.type        = 'text';
                input.name        = 'youtube_urls[]';
                input.placeholder = 'https://www.youtube.com/watch?v=…';
                input.className   = 'w-full py-2 pl-2 border border-gray-300 rounded-md mb-2';
                wrapper.appendChild(input);
            });
        })();
    </script>
</x-layouts.app>
