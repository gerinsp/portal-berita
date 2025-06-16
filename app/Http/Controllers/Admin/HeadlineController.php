<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Headline;
use App\Models\HeadlineCategory;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;

class HeadlineController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Headline::with(['post'])->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#updateModal'.$item->id.'">
                            <i class="fas fa-sync-alt"></i> &nbsp; Ganti
                        </button>
                        <form action="' . route('headline.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini secara permanen dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action','post_status'])
                ->make();
        }

        $posts = Post::with(['user','category'])->latest()->get();
        $all_post = Post::with(['user','category'])->latest()->get();
        $headline = Headline::latest()->get();

        return view('pages.admin.settings.headline',[
            'posts' => $posts,
            'all_post' => $all_post,
            'headline' => $headline
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required'
        ]);

        Headline::create($validatedData);

        return redirect()
                    ->route('headline.index')
                    ->with('success', 'Sukses! Data Berhasil Disimpan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'post_id' => 'required'
        ]);

        Headline::where('id', $id)
                ->update([
                    'post_id' => $request->post_id
                ]);

        return redirect()
                    ->route('headline.index')
                    ->with('success', 'Sukses! Data telah diperbarui');
    }

    public function destroy($id)
    {
        $item = Headline::findorFail($id);

        $item->delete();

        return redirect()
                    ->route('breaking-news.index')
                    ->with('success', 'Sukses! Data Berhasil Dihapus');
    }

    public function categories()
    {
        $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();

        return view('pages.admin.headline.index',[
            'categories' => $categories
        ]);
    }

    public function headline($id)
    {
        
        if (request()->ajax()) {
            $query = HeadlineCategory::with(['post'])->where('category_id', $id)->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#updateModal'.$item->id.'">
                            <i class="fas fa-sync-alt"></i> &nbsp; Ganti
                        </button>
                        <form action="' . route('destroy-headline-category', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini secara permanen dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action','post_status'])
                ->make();
        }

        $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
        $posts = Post::with(['user','category'])->where('categories_id', $id)->orWhere('sub_categories', $id)->latest()->get();

        $breaking = HeadlineCategory::latest()->get();
        $row = Category::findOrFail($id);

        return view('pages.admin.headline.list',[
            'posts' => $posts,
            'categories' => $categories,
            'breaking' => $breaking,
            'row' => $row,
        ]);
    }

    public function store_category(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required',
            'category_id' => 'required',
        ]);

        $category_id = $request->category_id;

        HeadlineCategory::create($validatedData);

        return redirect()
                    ->route('headline-list', $category_id)
                    ->with('success', 'Sukses! Data Berhasil Disimpan');
    }

    public function update_category(Request $request, $id)
    {
        $request->validate([
            'post_id' => 'required',
            'category_id' => 'required'
        ]);

        $category_id = $request->category_id;

        HeadlineCategory::where('id', $id)
                ->update([
                    'post_id' => $request->post_id,
                    'category_id' => $request->category_id
                ]);

        return redirect()
                    ->route('headline-list', $category_id)
                    ->with('success', 'Sukses! Data telah diperbarui');
    }

    public function destroy_category($id)
    {
        $item = HeadlineCategory::findorFail($id);

        $category_id = $item->category_id;

        $item->delete();

        return redirect()
                    ->route('headline-list', $category_id)
                    ->with('success', 'Sukses! Data Berhasil Dihapus');
    }
}
