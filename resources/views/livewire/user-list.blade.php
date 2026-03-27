<div class="p-4 sm:p-6">
  @if (session()->has('message'))
    <div class="mb-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 px-4 py-3 text-sm text-green-700 dark:text-green-300">
      {{ session('message') }}
    </div>
  @endif

  <div class="mb-6">
    <div class="relative">
      <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
      </svg>
      <input
        type="text"
        wire:model.live="search"
        placeholder="メールアドレスまたはユーザー名で検索..."
        class="w-full pl-10 pr-4 py-2.5 border border-neutral-200 dark:border-neutral-700 rounded-xl bg-white dark:bg-neutral-800 text-sm text-neutral-900 dark:text-neutral-100 placeholder-neutral-400 dark:placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-neutral-300 dark:focus:ring-neutral-600 transition"
      >
    </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($users as $user)
      <div class="bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
        <div class="flex items-start gap-4">
          <img src="{{ asset('storage/avatar/' . ($user->avatar ?? 'user_default.jpg')) }}"
               alt="{{ $user->name }}"
               class="w-12 h-12 rounded-full object-cover border-2 border-neutral-100 dark:border-neutral-700 shrink-0">
          <div class="flex-1 min-w-0">
            <h3 class="text-sm font-semibold text-neutral-900 dark:text-neutral-100 truncate">{{ $user->name }}</h3>
            <p class="text-xs text-neutral-500 dark:text-neutral-400 truncate mt-0.5">{{ $user->email }}</p>
            <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">ID: {{ $user->id }}</p>
          </div>
        </div>

        <div class="mt-4 flex flex-wrap gap-1.5">
          @foreach ($roles as $role)
            @php $assigned = $user->roles->contains($role->id); @endphp
            <button wire:click="toggleRole({{ $user->id }}, {{ $role->id }})"
                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium transition-colors duration-150
                      {{ $assigned
                        ? 'bg-neutral-700 text-white dark:bg-neutral-200 dark:text-neutral-900'
                        : 'bg-neutral-100 text-neutral-500 dark:bg-neutral-700 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-600'
                      }}">
              {{ $role->name }}
            </button>
          @endforeach
        </div>

        <div class="mt-4 pt-3 border-t border-neutral-100 dark:border-neutral-700">
          <button wire:click="deleteUser({{ $user->id }})"
                  wire:confirm.prompt="本当に削除しますか？\n\n削除する場合はDELETEと入力してください|DELETE"
                  class="inline-flex items-center gap-1.5 text-xs text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
            削除
          </button>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-6">
    {{ $users->links() }}
  </div>
</div>
