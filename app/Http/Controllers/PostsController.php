<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\posts\StorePostRequest;
use App\Http\Requests\posts\UpdatePostRequest;

class PostsController extends Controller
{
    public function index()
    {
        return view('posts.index', [
           // 'posts' => Post::all()
           'posts' => Post::with('user')->paginate(3)
        ]);
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create',[
            'users' => $users,
        ]);
    }

    public function store(StorePostRequest $request)
    {
        Post::create($request->all());

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        $users = User::all();
        return view('posts.edit', [
            'post' => $post,
            'users'=> $users,
        ]);
    }

    public function update(UpdatePostRequest $request,Post $post)
    {

        $post->update($request->all());


        return redirect()->route('posts.index');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post has been deleted Successfully');
    }

    public function show($id)
    {
        return view('posts.show', [
            'post' => Post::find($id)
        ]);
    }
}


