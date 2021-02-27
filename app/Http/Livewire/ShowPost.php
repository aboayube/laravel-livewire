<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class ShowPost extends Component
{
    public $title;
    public $slug;
    public $body;
    public $image;
//اول ما يحمل صفحة يحمل 
    public function mount($slug)
    {
        $this->retrievePost($slug);
    }    public function returnToPosts()
    {
        return redirect()->route('posts');
    }
    //يستدعي هذي الدالة
    public function retrievePost($slug)
    {
        $post = Post::whereSlug($slug)->first();
        $this->title = $post->title;
        $this->body = $post->body;
        $this->image = $post->image;
    }
    public function render()
    {
        return view('livewire.show-post')->layout('layouts.app');
    }
}
