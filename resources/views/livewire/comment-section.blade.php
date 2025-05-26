<div class="space-y-8">

   {{-- フラッシュメッセージ --}}
    @if (session()->has('message'))
        <div class="text-green-600 text-sm">
            {{ session('message') }}
        </div>
    @endif

    {{-- コメント入力フォーム --}}
    <form wire:submit="save" class=" mb-12">
        <textarea wire:model="body"
            class="bg-white w-full rounded-2xl px-4 mt-4 py-4 shadow-lg hover:shadow-2xl transition duration-500" cols="30"
            rows="3" placeholder="コメントを入力してください"></textarea>
        <flux:button type="submit" class="float-right mr-4">
            コメントする
        </flux:button>
    </form> 

    {{-- コメント一覧 --}}
    <div class="space-y-6">
        @foreach ($comments as $comment)
            <div class="flex items-start space-x-4">
                {{-- 相手のアイコン --}}
                <img src="{{ asset('storage/avatar/' . ($comment->user->avatar ?? 'user_default.jpg')) }}"
                    alt="ユーザーアイコン" class="w-8 h-8 rounded-full object-cover mt-1">

                <div class="flex-1">
                    {{-- 本文 --}}
                    <p class="text-gray-800 text-sm whitespace-pre-line">
                        {{ $comment->body }}
                    </p>
                    {{-- 投稿者名・日時 --}}
                    <p class="text-gray-500 text-xs mt-1">
                        {{ $comment->user->name ?? '退会ユーザー' }} • {{ $comment->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
