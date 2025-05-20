<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class UserList extends Component
{
    // public $users;
    use WithPagination;
    public $roles;
    public $search = ''; 

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount():void
    {
        // $this->users = User::all();
        $this->roles = Role::all();
    }

    public function render()
    {
        // return view('livewire.user-list');

        $query = User::query();

        if ($this->search) {
            $query->where('email', 'like', "%{$this->search}%")
                  ->orWhere('name', 'like', "%{$this->search}%");
        }

        return view('livewire.user-list', [
            // 'users' => User::paginate(10)
            'users' => $query->paginate(10)
        ]);
    }

    public function deleteUser($userId)
    {
        // $user = User::findOrFail($userId);
        // $user->delete();
        // $this->users = User::all();
        // session()->flash('message', 'ユーザーを削除しました！');

        $user = User::findOrFail($userId);
        // 役割の削除
        $user->roles()->detach();
        // アバター画像の削除
        if ($user->avatar && $user->avatar !== 'user_default.jpg') {
            Storage::disk('public')->delete('avatar/' . $user->avatar);
        }
                
        $user->delete();
        session()->flash('message', 'ユーザーを削除しました！');
    }

    public function toggleRole($userId, $roleId)
    {
        $user = User::findOrFail($userId);
        // 既にその役割が付与されているかチェック
        if ($user->roles->contains($roleId)) {
            $user->roles()->detach($roleId);
        } else {
            $user->roles()->attach($roleId);
        }
    }
    
}
