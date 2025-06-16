<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Video;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class VideoController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Video::with(['user','category'])->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="btn btn-primary btn-xs" href="' . route('video.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('video.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                })
                ->editColumn('post_status', function ($item) {
                   return $item->post_status == 'Published' ? '<div class="badge bg-green-soft text-green">'.$item->post_status.'</div>':'<div class="badge bg-gray-200 text-dark">'.$item->post_status.'</div>';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action','post_status'])
                ->make();
        }

        $all = Video::count();
        $published = Video::where('post_status','Published')->count();
        $draft = Video::where('post_status','Draft')->count();
        $trash = Video::onlyTrashed()->count();

        return view('pages.admin.video.index',[
            'all' => $all,
            'published' => $published,
            'draft' => $draft,
            'trash' => $trash
        ]);
    }

    public function published()
    {
        if (request()->ajax()) {
            $query = Video::where('post_status','Published')->with(['user','category'])->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="btn btn-primary btn-xs" href="' . route('video.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('video.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                })
                ->editColumn('post_status', function ($item) {
                   return $item->post_status == 'Published' ? '<div class="badge bg-green-soft text-green">'.$item->post_status.'</div>':'<div class="badge bg-gray-200 text-dark">'.$item->post_status.'</div>';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action','post_status'])
                ->make();
        }

        $all = Video::count();
        $published = Video::where('post_status','Published')->count();
        $draft = Video::where('post_status','Draft')->count();
        $trash = Video::onlyTrashed()->count();

        return view('pages.admin.video.index',[
            'all' => $all,
            'published' => $published,
            'draft' => $draft,
            'trash' => $trash
        ]);
    }

    public function draft()
    {
        if (request()->ajax()) {
            $query = Video::where('post_status','Draft')->with(['user','category'])->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="btn btn-primary btn-xs" href="' . route('video.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('video.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                })
                ->editColumn('post_status', function ($item) {
                   return $item->post_status == 'Published' ? '<div class="badge bg-green-soft text-green">'.$item->post_status.'</div>':'<div class="badge bg-gray-200 text-dark">'.$item->post_status.'</div>';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action','post_status'])
                ->make();
        }

        $all = Video::count();
        $published = Video::where('post_status','Published')->count();
        $draft = Video::where('post_status','Draft')->count();
        $trash = Video::onlyTrashed()->count();

        return view('pages.admin.video.index',[
            'all' => $all,
            'published' => $published,
            'draft' => $draft,
            'trash' => $trash
        ]);
    }

    public function trash()
    {
        if (request()->ajax()) {
            $query = Video::onlyTrashed()->with(['user','category'])->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="btn btn-primary btn-xs" href="' . route('video-restore', $item->id) . '">
                            <i class="fas fa-sync"></i> &nbsp; Kembalikan
                        </a>
                        <form action="' . route('video-force-delete', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini secara permanen dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus Permanen
                            </button>
                        </form>
                    ';
                })
                ->editColumn('post_status', function ($item) {
                   return $item->post_status == 'Published' ? '<div class="badge bg-green-soft text-green">'.$item->post_status.'</div>':'<div class="badge bg-gray-200 text-dark">'.$item->post_status.'</div>';
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action','post_status'])
                ->make();
        }

        $all = Video::count();
        $published = Video::where('post_status','Published')->count();
        $draft = Video::where('post_status','Draft')->count();
        $trash = Video::onlyTrashed()->count();

        return view('pages.admin.video.index',[
            'all' => $all,
            'published' => $published,
            'draft' => $draft,
            'trash' => $trash
        ]);
    }

    public function create()
    {
        $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
        $tags = Tag::all();

        return view('pages.admin.video.create',[
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'categories_id' => 'required',
            'sub_categories' => 'nullable',
            'post_title' => 'required|max:255',
            'post_teaser' => 'required|max:100',
            'post_content' => 'required',
            'slug' => 'unique:posts',
            'post_image' => 'required|image|file|max:1024',
            'post_image_description' => 'required',
        ]);

        $content = $request->post_content;

        $validatedData['post_content'] = $content;

        if($request->file('post_image')){
            $image = $request->file('post_image');
            $path = $image->hashName('assets/videos-images');

            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1200,675);

            Storage::put($path, (string) $image_resize->encode());

            $validatedData['post_image'] = $path;
            //$validatedData['post_image'] = $request->file('post_image')->store('assets/videos-images');
        }

        if($request->publish){
            $validatedData['post_status'] = 'Published';
        }else{
            $validatedData['post_status'] = 'Draft';
        }

        $validatedData['users_id'] = auth()->user()->id;
        $validatedData['slug'] = Str::slug($request->post_title);

        $video = Video::create($validatedData);

        $video->tag()->attach($request->tags);

        return redirect()
                    ->route('video.index')
                    ->with('success', 'Sukses! Video Berhasil Disimpan');
    }

    public function edit($id)
    {
        $item = Video::findOrFail($id);
        $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
        $sub_categories = Category::where('parent_id', $item->categories_id)->orderby('name', 'asc')->get();
        $tags = Tag::all();

        return view('pages.admin.video.edit',[
            'item' => $item,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'tags' => $tags,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'categories_id' => 'required',
            'post_title' => 'required|max:255',
            'post_content' => 'required',
            'post_image' => 'image|file|max:1024',
            'post_image_description' => 'required',
        ]);

        $item = Video::findOrFail($id);

        $content = $request->post_content;

        $validatedData['post_content'] = $content;

        if($request->file('post_image')){
            Storage::delete($item->post_image);
            $image = $request->file('post_image');
            $path = $image->hashName('assets/videos-images');

            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1200,675);

            Storage::put($path, (string) $image_resize->encode());

            $validatedData['post_image'] = $path;
            //$validatedData['post_image'] = $request->file('post_image')->store('assets/videos-images');
        }

        if($request->publish){
            $validatedData['post_status'] = 'Published';
        }else{
            $validatedData['post_status'] = 'Draft';
        }

        $validatedData['slug'] = Str::slug($request->post_title);

        $item->update($validatedData);

        $item->tag()->sync($request->tags);

        return redirect()
                    ->route('video.edit', $item->id)
                    ->with('success', 'Sukses! Data Berhasil Diubah');
    }

    public function destroy($id)
    {
        $item = Video::findorFail($id);

        $item->delete();

        return redirect()
                    ->route('video.index')
                    ->with('success', 'Sukses! Video Berhasil Dihapus');
    }

    public function force_delete($id)
    {
        $item = Video::onlyTrashed()->findOrFail($id);

        Storage::delete($item->post_image); 
        
        $item->forceDelete();

        return redirect()
                    ->route('video-trash')
                    ->with('success', 'Sukses! 1 Video dihapus secara permanen.');
    }

    public function restore_data($id)
    {
        Video::withTrashed()->find($id)->restore();

        return redirect()
                    ->route('video-trash')
                    ->with('success', 'Sukses! 1 Video berhasil dikembalikan dari sampah.');
    }
}
