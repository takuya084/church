<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 投稿者本人かどうかを判定
        Gate::define('post-owner', function ($user, $post) {
            return $user->id === $post->user_id;
        });

         // 管理者かどうかを判定
         Gate::define('admin', function($user) {
            foreach($user->roles as $role){
                if($role->name=='admin') {
                    return true;
                }   
            }
            return false;
        });
    }
}
