<div class="p-6">
    <div class="overflow-x-auto">
        @if (session()->has('message'))
            <div class="text-green-600 mb-4">
                {{ session('message') }}
            </div>
        @endif
        <div class="mb-4">
            <input type="text" 
                   wire:model.live="search" 
                   placeholder="メールアドレスまたはユーザー名で検索..." 
                   class="w-full px-4 py-2 border rounded-lg">
        </div>
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID</th>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        アバター</th>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        名前</th>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        メールアドレス</th>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        削除</th>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        役割（クリックで付与・削除）</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/avatar/' . ($user->avatar ?? 'user_default.jpg')) }}"
                                class="w-10">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                        <td>
                            <flux:button variant="danger" wire:click="deleteUser({{ $user->id }})"
                                wire:confirm.prompt="本当に削除しますか？\n\n削除する場合はDELETEと入力してください|DELETE">削除</flux:button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach ($roles as $role)
                                @php
                                    // ユーザーにこの役割が付与されているかどうか
                                    $assigned = $user->roles->contains($role->id);
                                @endphp
                                {{-- wire:click追加 --}}
                                <span wire:click="toggleRole({{ $user->id }}, {{ $role->id }})"
                                    class="inline-block cursor-pointer px-2 py-1 rounded mr-1 {{ $assigned ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                {{ $users->links() }}
            </tbody>
        </table>
    </div>
</div>
