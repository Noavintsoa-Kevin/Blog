<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Routing\Controller;

use App\Http\Requests\UpdatePostRequest;
use Illuminate\Auth\Access\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts= Post::with('user')->latest() ->get();
        return view('Post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Post.create');
    }

    /**
     * Store a newly created resource in storage.
     *;
     * @param  App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {   
        Post::create([
            'titre'=>$request->titre,
            'contenue'=> $request->contenue
        ]);
      
        return redirect()->route('dashboard')->with('success', 'Votre post a ete cree');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, $id)
    {
      $post = Post::findOrFail($id);
        return view('Post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, $id)
    { 
        $post=Post::find($id);
        return view('Post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post, $id)
    {
       $post =Post::find($id);
       $post->titre =$request->input('titre');
       $post->contenue=$request->input('contenue');
       $post->save();



        return redirect()->route('dashboard')->with('success', 'Votre post a ete modifier');

        

    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, $id)
    {
        $post = Post:: findOrFail($id);
        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Votre post a ete supprimer');
    }
}
