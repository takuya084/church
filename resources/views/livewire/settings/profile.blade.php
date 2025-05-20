<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
// 追加
use Livewire\WithFileUploads;

new class extends Component {
    // 追加
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    // 追加
    public $avatar;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            // 追加
            'avatar' => ['nullable', 'image', 'max:1024'],
        ]);

        // 追加
        if ($this->avatar) {
            // 古いアバターを削除
            if ($user->avatar !== 'user_default.jpg') {
                Storage::disk('public')->delete('avatar/' . $user->avatar);
            }

            $timestamp = now()->format('YmdHis');
            $originalName = $this->avatar->getClientOriginalName();
            $filename = $timestamp . '_' . $originalName;
            $this->avatar->storeAs('avatar', $filename, 'public');
            $validated['avatar'] = $filename;
        } else {
            unset($validated['avatar']);
        }
        // 追加ここまで

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>


<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer"
                                wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            {{-- 追加 --}}
            <div>
                <label for="avatar" class="block text-sm font-medium text-gray-700">アバター</label>
                <div class="my-2">
                    {{-- 新しく選択した画像がある場合はそのプレビューを表示 --}}
                    @if ($avatar)
                        <p class="text-sm text-gray-500 mb-1">プレビュー：</p>
                        <img src="{{ $avatar->temporaryUrl() }}" alt="Avatar Preview" class="w-50 rounded-full">
                        {{-- 選択されていない場合は現在のアバターを表示 --}}
                    @elseif (auth()->user()->avatar)
                        <p class="text-sm text-gray-500 mb-1">現在のアバター：</p>
                        <img src="{{ asset('storage/avatar/' . (auth()->user()->avatar ?? 'user_default.jpg')) }}"
                            alt="Current Avatar" class="w-50 rounded-full">
                    @endif
                </div>


                <flux:input id="avatar" type="file" wire:model="avatar" class="mt-1 block w-full" />

                {{-- アップロード中の表示を追加 --}}
                <div wire:loading wire:target="avatar" class="text-sm text-gray-500 mt-1">
                    アップロード中...
                </div>

                @error('avatar')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

            </div>
            {{-- 追加ここまで --}}

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        {{-- <livewire:settings.delete-user-form /> --}}
    </x-settings.layout>
</section>
