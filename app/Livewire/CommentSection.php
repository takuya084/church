<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentForm;


class CommentSection extends Component
{

    public $post;
    public $body = '';
    public $comments;

    public function mount()
    {
        $this->loadComments();
    }

    
    private function loadComments()
    {
        $this->comments = $this->post->comments()->orderBy('created_at', 'desc')->get();
    }

    public function save()
    {
        $inputs = $this->validate([
            'body' => 'required|max:1000',
        ]);

        // 投稿の保存方法＿１
        $comment = new Comment();
        $comment->body = $inputs['body'];
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $this->post->id;
        $comment->save();

        // 投稿の保存方法＿２
        // $comment=Comment::create([
        //     'body'=>$inputs['body'],
        //     'user_id'=>auth()->user()->id,
        //     'post_id'=>$this->post->id
        // ]);

        $commentUser = $comment->post->user->email;
        $post = $comment->post;
        if ($commentUser != auth()->user()->email) {
            Mail::to($commentUser)->send(new CommentForm($inputs, $post));
        }

        $this->reset('body');
        $this->loadComments();
        session()->flash('message', 'コメントが送信されました。');
    }

    public function render()
    {
        return view('livewire.comment-section');
    }
}
