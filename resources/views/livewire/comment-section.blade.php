<div class="space-y-6">

    {{-- フラッシュメッセージ --}}
    @if (session()->has('message'))
        <div class="flex items-center gap-2 text-green-600 dark:text-green-400 text-sm bg-green-50 dark:bg-green-900/20 px-4 py-2.5 rounded-xl">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
            {{ session('message') }}
        </div>
    @endif

    {{-- コメント入力フォーム --}}
    <form wire:submit="save">
        <textarea wire:model="body"
            class="w-full rounded-xl px-4 py-3 text-sm bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition-all duration-200 resize-none"
            rows="3" placeholder="コメントを入力してください..."></textarea>
        <div class="flex justify-end mt-2">
            <flux:button type="submit" size="sm" class="!rounded-lg !text-xs">
                コメントする
            </flux:button>
        </div>
    </form>

    {{-- コメント一覧 --}}
    @if($comments->count())
        <div class="space-y-4 pt-2">
            <h3 class="text-sm font-semibold text-neutral-500 dark:text-neutral-400">
                コメント ({{ $comments->count() }})
            </h3>
            @foreach ($comments as $comment)
                <div class="flex items-start gap-3 group">
                    <img src="{{ asset('storage/avatar/' . ($comment->user->avatar ?? 'user_default.jpg')) }}"
                        alt="ユーザーアイコン"
                        class="w-8 h-8 rounded-full object-cover ring-2 ring-neutral-100 dark:ring-neutral-700 flex-shrink-0 mt-0.5">

                    <div class="flex-1 bg-white dark:bg-neutral-900 rounded-xl px-4 py-3 border border-neutral-100 dark:border-neutral-700">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-semibold text-neutral-700 dark:text-neutral-300">
                                {{ $comment->user->name ?? '退会ユーザー' }}
                            </span>
                            <span class="text-xs text-neutral-400 dark:text-neutral-500">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 whitespace-pre-line leading-relaxed">{{ $comment->body }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
