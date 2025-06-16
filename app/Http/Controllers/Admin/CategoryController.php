<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
        return view('pages.admin.category.index',[
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories',
            'parent_id' => 'nullable|numeric'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id
        ]);

        return redirect()
                    ->route('category.index')
                    ->with('success', 'Sukses! 1 Kategori Berhasil Disimpan');
    }

    public function edit($id)
    {
        $item = Category::findOrFail($id);
        $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();

        return view('pages.admin.category.edit',[
            'item' => $item,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'parent_id' => 'nullable|numeric'
        ]);

        Category::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'parent_id' => $request->parent_id
                ]);

        return redirect()
                    ->route('category.index')
                    ->with('success', 'Sukses! 1 Kategori telah diperbarui');
    }

    public function destroy($id)
    {
        $item = Category::findorFail($id);
        $item->delete();

        return redirect()
                ->route('category.index')
                ->with('success', 'Sukses! 1 Kategori telah dihapus');
    }
}
