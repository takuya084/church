<div class="p-4 sm:p-6 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
  <div class="overflow-x-auto">
    @if (session()->has('message'))
      <div class="text-green-600 dark:text-green-400 mb-4">
        {{ session('message') }}
      </div>
    @endif

    <div class="mb-4">
      <input
        type="text"
        wire:model.live="search"
        placeholder="メールアドレスまたはユーザー名で検索..."
        class="
          w-full px-3 py-2 sm:px-4 sm:py-2
          border border-gray-300 dark:border-gray-600
          rounded-lg
          bg-white dark:bg-gray-700
          text-sm sm:text-base text-gray-900 dark:text-gray-100
          placeholder-gray-500 dark:placeholder-gray-400
        "
      >
    </div>

    <table class="min-w-full bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
      <!-- モバイルではヘッダー非表示、sm以上は表示 -->
      <thead class="hidden sm:table-header-group bg-gray-50 dark:bg-gray-600">
        <tr>
          <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-500 text-left text-xs sm:text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">ID</th>
          <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-500 text-left text-xs sm:text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">アバター</th>
          <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-500 text-left text-xs sm:text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">名前</th>
          <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-500 text-left text-xs sm:text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300 hidden md:table-cell">メールアドレス</th>
          <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-500 text-left text-xs sm:text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">削除</th>
          <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-500 text-left text-xs sm:text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">役割</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
        @foreach ($users as $user)
          <!-- モバイルは flex-col、sm以上は table-row -->
          <tr class="flex flex-col sm:table-row">
            <td class="flex justify-between px-4 py-2 sm:px-6 sm:py-4 text-sm sm:text-base text-gray-900 dark:text-gray-100">
              <span class="font-semibold sm:hidden">ID:</span>
              {{ $user->id }}
            </td>
            <td class="flex justify-between px-4 py-2 sm:px-6 sm:py-4">
              <span class="font-semibold sm:hidden">アバター:</span>
              <img src="{{ asset('storage/avatar/' . ($user->avatar ?? 'user_default.jpg')) }}"
                   class="w-10 h-10 rounded-full border border-gray-300 dark:border-gray-600">
            </td>
            <td class="flex justify-between px-4 py-2 sm:px-6 sm:py-4 text-sm sm:text-base text-gray-900 dark:text-gray-100">
              <span class="font-semibold sm:hidden">名前:</span>
              {{ $user->name }}
            </td>
            <td class="flex justify-between px-4 py-2 sm:px-6 sm:py-4 text-sm sm:text-base text-gray-900 dark:text-gray-100 hidden md:flex">
              <span class="font-semibold md:hidden">メール:</span>
              {{ $user->email }}
            </td>
            <td class="flex justify-between px-4 py-2 sm:px-6 sm:py-4">
              <span class="font-semibold sm:hidden">削除:</span>
              <flux:button variant="danger"
                           wire:click="deleteUser({{ $user->id }})"
                           wire:confirm.prompt="本当に削除しますか？\n\n削除する場合はDELETEと入力してください|DELETE">
                削除
              </flux:button>
            </td>
            <td class="px-4 py-2 sm:px-6 sm:py-4">
              <div class="flex flex-wrap">
                @foreach ($roles as $role)
                  @php $assigned = $user->roles->contains($role->id); @endphp
                  <span wire:click="toggleRole({{ $user->id }}, {{ $role->id }})"
                        class="
                          inline-block cursor-pointer px-2 py-1 rounded mr-1 mb-1
                          {{ $assigned
                            ? 'bg-blue-500 text-white dark:bg-blue-400'
                            : 'bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-300'
                          }}
                          text-xs sm:text-sm
                        ">
                    {{ $role->name }}
                  </span>
                @endforeach
              </div>
            </td>
          </tr>
        @endforeach
        {{ $users->links() }}
      </tbody>
    </table>
  </div>
</div>
