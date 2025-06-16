<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tag;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Tag::latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="btn btn-primary btn-xs" href="' . route('tag.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('tag.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini secara permanen dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.admin.tag.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories',
        ]);

        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()
                    ->route('tag.index')
                    ->with('success', 'Sukses! Data Berhasil Disimpan');
    }

    public function edit($id)
    {
        $item = Tag::findOrFail($id);

        return view('pages.admin.tag.edit',[
            'item' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        Tag::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                ]);

        return redirect()
                    ->route('tag.index')
                    ->with('success', 'Sukses! Kategori telah diperbarui');
    }

    public function destroy($id)
    {
        $item = Tag::findorFail($id);
        $item->delete();

        return redirect()
                ->route('tag.index')
                ->with('success', 'Sukses! Kategori telah dihapus');
    }


    
}
