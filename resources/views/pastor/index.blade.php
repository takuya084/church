<x-layouts.app>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-neutral-100 dark:border-neutral-700 overflow-hidden">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-gray-700 to-gray-600 px-6 py-5">
                <h2 class="text-lg font-bold text-white tracking-wide">牧師管理</h2>
                <p class="text-sm text-gray-300 mt-1">投稿時に選択できる牧師名を管理します</p>
            </div>

            <div class="p-6 sm:p-8">
                <x-message :message="session('message')" type="success" />
                <x-message :message="$errors->all()" type="error" />

                {{-- 登録フォーム --}}
                <form method="post" action="{{ route('pastor.store') }}" class="flex items-end gap-3 mb-8">
                    @csrf
                    <div class="flex-1">
                        <label for="name" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">牧師名</label>
                        <input type="text" name="name" id="name"
                               class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition-all duration-200"
                               placeholder="牧師名を入力..."
                               value="{{ old('name') }}"
                               required>
                    </div>
                    <flux:button variant="primary" type="submit" class="!py-3 !px-6 !rounded-xl !text-sm !font-semibold">
                        登録
                    </flux:button>
                </form>

                {{-- 一覧 --}}
                @if($pastors->isEmpty())
                    <p class="text-sm text-neutral-400 dark:text-neutral-500 text-center py-8">牧師が登録されていません</p>
                @else
                    <div class="space-y-2">
                        @foreach ($pastors as $pastor)
                            <div class="flex items-center justify-between px-4 py-3 bg-neutral-50 dark:bg-neutral-900 rounded-xl border border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0" />
                                    </svg>
                                    <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">{{ $pastor->name }}</span>
                                </div>
                                <form method="post" action="{{ route('pastor.destroy', $pastor) }}" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                            onclick="return confirm('「{{ $pastor->name }}」を削除しますか？')"
                                            class="p-1.5 text-neutral-400 hover:text-red-500 transition-colors rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
