<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            if(Auth::user()->roles == 'Administrator' || Auth::user()->roles == 'Editor'){
                $query = Post::with(['user','category'])->latest()->get();
            }else{
                $query = Post::where('users_id', Auth::user()->id)->with(['user','category'])->latest()->get();
            }    

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return Auth::user()->roles == 'Administrator'? '
                        <a class="btn btn-primary btn-xs" href="' . route('post.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('post.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ':'
                        <a class="btn btn-primary btn-xs" href="' . route('post.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
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

        if(Auth::user()->roles == 'Administrator' || Auth::user()->roles == 'Editor'){
            $all = Post::count();
            $published = Post::where('post_status','Published')->count();
            $draft = Post::where('post_status','Draft')->count();
            $trash = Post::onlyTrashed()->count();
        }else{
            $all = Post::where('users_id', Auth::user()->id)->count();
            $published = Post::where(['post_status' => 'Published', 'users_id' => Auth::user()->id])->count();
            $draft = Post::where(['post_status'=>'Draft', 'users_id' => Auth::user()->id])->count();
            $trash = Post::onlyTrashed()->count();
        }

        return view('pages.admin.post.index',[
            'all' => $all,
            'published' => $published,
            'draft' => $draft,
            'trash' => $trash
        ]);
    }

    public function published()
    {
        if (request()->ajax()) {
            if(Auth::user()->roles == 'Administrator' || Auth::user()->roles == 'Editor'){
                $query = Post::where('post_status','Published')->with(['user','category'])->latest()->get();
            }else{
                $query = Post::where(['post_status' => 'Published', 'users_id' => Auth::user()->id])->with(['user','category'])->latest()->get();
            }    
            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return Auth::user()->roles == 'Administrator'? '
                        <a class="btn btn-primary btn-xs" href="' . route('post.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('post.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ':'
                        <a class="btn btn-primary btn-xs" href="' . route('post.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
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

        if(Auth::user()->roles == 'Administrator' || Auth::user()->roles == 'Editor'){
            $all = Post::count();
            $published = Post::where('post_status','Published')->count();
            $draft = Post::where('post_status','Draft')->count();
            $trash = Post::onlyTrashed()->count();
        }else{
            $all = Post::where('users_id', Auth::user()->id)->count();
            $published = Post::where(['post_status' => 'Published', 'users_id' => Auth::user()->id])->count();
            $draft = Post::where(['post_status'=>'Draft', 'users_id' => Auth::user()->id])->count();
            $trash = Post::onlyTrashed()->count();
        }

        return view('pages.admin.post.index',[
            'all' => $all,
            'published' => $published,
            'draft' => $draft,
            'trash' => $trash
        ]);
    }

    public function draft()
    {
        if (request()->ajax()) {
            if(Auth::user()->roles == 'Administrator' || Auth::user()->roles == 'Editor'){
                $query = Post::where('post_status','Draft')->with(['user','category'])->latest()->get();
            }else{
                $query = Post::where(['post_status' => 'Draft', 'users_id' => Auth::user()->id])->with(['user','category'])->latest()->get();
            }

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return Auth::user()->roles == 'Administrator'? '
                        <a class="btn btn-primary btn-xs" href="' . route('post.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('post.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ':'
                        <a class="btn btn-primary btn-xs" href="' . route('post.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
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

        if(Auth::user()->roles == 'Administrator' || Auth::user()->roles == 'Editor'){
            $all = Post::count();
            $published = Post::where('post_status','Published')->count();
            $draft = Post::where('post_status','Draft')->count();
            $trash = Post::onlyTrashed()->count();
        }else{
            $all = Post::where('users_id', Auth::user()->id)->count();
            $published = Post::where(['post_status' => 'Published', 'users_id' => Auth::user()->id])->count();
            $draft = Post::where(['post_status'=>'Draft', 'users_id' => Auth::user()->id])->count();
            $trash = Post::onlyTrashed()->count();
        }

        return view('pages.admin.post.index',[
            'all' => $all,
            'published' => $published,
            'draft' => $draft,
            'trash' => $trash
        ]);
    }

    public function trash()
    {
        if (request()->ajax()) {
            $query = Post::onlyTrashed()->with(['user','category'])->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="btn btn-primary btn-xs" href="' . route('post-restore', $item->id) . '">
                            <i class="fas fa-sync"></i> &nbsp; Kembalikan
                        </a>
                        <form action="' . route('post-force-delete', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini secara permanen dari situs anda?'".')">
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

        $all = Post::count();
        $published = Post::where('post_status','Published')->count();
        $draft = Post::where('post_status','Draft')->count();
        $trash = Post::onlyTrashed()->count();

        return view('pages.admin.post.index',[
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

        return view('pages.admin.post.create',[
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
            'post_teaser' => 'required',
            'post_content' => 'required',
            'slug' => 'unique:posts',
            'post_image' => 'required|image|file|max:1024',
            'post_image_description' => 'required',
        ]);

        $content = $request->post_content;

        $validatedData['post_content'] = $content;
        $validatedData['post_teaser'] = Str::limit(strip_tags($request->post_teaser), 140);

        if($request->file('post_image')){
            
            $image = $request->file('post_image');
            $path = $image->hashName('assets/post-images');

            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1200,675);

            Storage::put($path, (string) $image_resize->encode());

            $validatedData['post_image'] = $path;
            //$validatedData['post_image'] = $request->file('post_image')->store('assets/post-images');
        }

        if($request->publish){
            $validatedData['post_status'] = 'Published';
        }else{
            $validatedData['post_status'] = 'Draft';
        }

        if($request->is_schedule == 'Ya'){
            $validatedData['published_at'] = $request->published_at;
        }else{
            $validatedData['published_at'] = date('Y-m-d H:i:s');
        }

        $validatedData['users_id'] = auth()->user()->id;
        $validatedData['slug'] = Str::slug($request->post_title);

        $post = Post::create($validatedData);

        $post->tag()->attach($request->tags);

        return redirect()
                    ->route('post.index')
                    ->with('success', 'Sukses! Pos Berhasil Disimpan');
    }

    public function edit($id)
    {
        $item = Post::findOrFail($id);
        $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
        $sub_categories = Category::where('parent_id', $item->categories_id)->orderby('name', 'asc')->get();
        $tags = Tag::all();

        return view('pages.admin.post.edit',[
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
            'sub_categories' => 'nullable',
            'post_title' => 'required|max:255',
            'post_teaser' => 'required',
            'post_content' => 'required',
            'post_image' => 'image|file|max:1024',
            'post_image_description' => 'required',
        ]);

        $item = Post::findOrFail($id);

        if($request->file('post_image')){
            Storage::delete($item->post_image);
            $image = $request->file('post_image');
            $path = $image->hashName('assets/post-images');

            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1200,675);

            Storage::put($path, (string) $image_resize->encode());

            $validatedData['post_image'] = $path;
            //$validatedData['post_image'] = $request->file('post_image')->store('assets/post-images');
        }

        if($request->publish){
            $validatedData['post_status'] = 'Published';
        }else{
            $validatedData['post_status'] = 'Draft';
        }

        $validatedData['published_at'] = $request->published_at;

        $validatedData['slug'] = Str::slug($request->post_title);
        $validatedData['post_teaser'] = Str::limit(strip_tags($request->post_teaser), 140);

        $item->update($validatedData);

        $item->tag()->sync($request->tags);

        return redirect()
                    ->route('post.edit',$item->id)
                    ->with('success', 'Sukses! Pos Berhasil Diubah');
    }

    public function destroy($id)
    {
        $item = Post::findorFail($id);

        $item->delete();

        return redirect()
                    ->route('post.index')
                    ->with('success', 'Sukses! Pos Berhasil Dihapus');
    }

    public function force_delete($id)
    {
        $item = Post::onlyTrashed()->findOrFail($id);

        Storage::delete($item->post_image); 
        
        $item->forceDelete();

        return redirect()
                    ->route('post-trash')
                    ->with('success', 'Sukses! 1 Pos dihapus secara permanen.');
    }

    public function restore_data($id)
    {
        Post::withTrashed()->find($id)->restore();

        return redirect()
                    ->route('post-trash')
                    ->with('success', 'Sukses! 1 Pos berhasil dikembalikan dari sampah.');
    }

    public function get_sub_categories(Request $request)
    {
        $parent_id = $request->cat_id;

        $subcategories = Category::where('id',$parent_id)
                          ->with('subcategory')
                          ->get();
        
        return response()->json([
            'subcategories' => $subcategories
        ]);
    }
}
