<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get(); // mengambil semua data post dengan urutan terbaru dan mengembalikan koleksi data
        return view('posts.index', compact('posts'));// menampilkan tampilan index.blade.php dengan mem-passing data
        // $posts = Post::all();
        // return view('post.index')->with('posts', $posts);
    }

    public function create()
    {
        return view('posts.create'); // menampilkan tampilan create.blade.php untuk menambahkan data Post baru
    }

    public function store(Request $request)
    {
        $this->validate($request, [ // validasi data inputan dari form
            'nama_nasabah' => 'required|string|max:100',
            'pinjam' => 'required|string|max:155',
            'bunga' => 'required|string|max:13',
            'keterangan' => 'required|string|max:15'
        ]);

        $post = Post::create([  // membuat data Post baru dengan data inputan dari form
            'nama_nasabah' => $request->nama_nasabah,
            'pinjam' => $request->pinjam,
            'bunga' => $request->bunga,
            'keterangan' => $request->keterangan
        ]);

        if ($post) {  // jika data berhasil ditambahkan, maka redirect ke halaman index.blade.php dengan pesan sukses
            return redirect()
                ->route('post.index')
                ->with([
                    'success' => 'Data Berhasil Di Tambah'
                ]);
        } else {  // jika gagal, maka redirect ke halaman sebelumnya dengan pesan error
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Data Gagal Di Tambah'
                ]);
        }
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id); // mencari data Post berdasarkan id yang di-passing
        return view('posts.edit', compact('post')); // menampilkan tampilan edit.blade.php dengan mem-passing data 
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [ // validasi data inputan dari form
            'nama_nasabah' => 'required|string|max:100',
            'pinjam' => 'required|string|max:155',
            'bunga' => 'required|string|max:13',
            'keterangan' => 'required|string|max:15'
        ]);

        $post = Post::findOrFail($id); // mencari data Post berdasarkan id yang di-passing

        $post->update([ // mengubah data Post dengan data inputan dari form
            'nama_nasabah' => $request->nama_nasabah,
            'pinjam' => $request->pinjam,
            'bunga' => $request->bunga,
            'keterangan' => $request->keterangan
        ]);

        if ($post) { // jika perubahan data berhasil dilakukan
            return redirect()
                ->route('post.index')
                ->with([
                    'success' => 'Data Berhasil Di Edit'
                ]);
        } else {  // jika perubahan data gagal dilakukan
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Data Gagal Di Edit'
                ]);
        }
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id); // mencari data Post berdasarkan id yang di-passing
        $post->delete(); // menghapus data Post tersebut dari database

        if ($post) { // jika penghapusan data berhasil dilakukan
            return redirect()
                ->route('post.index')
                ->with([
                    'success' => 'Data Berhasil Di Hapus'
                ]);
        } else { // jika penghapusan data berhasil dilakukan
            return redirect()
                ->route('post.index')
                ->with([
                    'error' => 'Data Gagal Di HApus'
                ]);
        }
    }
}
