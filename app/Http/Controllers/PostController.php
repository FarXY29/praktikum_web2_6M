<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required|string',
            'isi' => 'required|string',
        ]);

        $data = $request->only(['judul', 'isi']);
        $data['user_id'] = auth::user()->id;

        Post::create($data);

        return redirect()->route('home')->with('success', 'Postingan Berhasil Disimpan');
    }

    public function storeEdit($id)
    {
        $post = Post::find($id);
        return view('post_edit', compact('post'));
    }

    public function storeUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required|string',
            'isi' => 'required|string',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->only('judul', 'isi'));
        return redirect()->route('home')->with('success', 'Postingan Berhasil Diubah');
    }

    public function storeDelete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('home')->with('success', 'Postingan Berhasil Dihapus');
    }
}
