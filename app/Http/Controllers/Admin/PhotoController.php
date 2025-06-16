<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Photo;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\PhotoGallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PhotoController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {

            if(Auth::user()->roles == 'Administrator' || Auth::user()->roles == 'Editor'){
                $query = Photo::with(['user','category'])->latest()->get();
            }else{
                $query = Photo::where('users_id', Auth::user()->id)->with(['user','category'])->latest()->get();
            }

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return Auth::user()->roles == 'Administrator'? '
                        <a class="btn btn-primary btn-xs" href="' . route('photo.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('photo.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ':'
                        <a class="btn btn-primary btn-xs" href="' . route('photo.edit', $item->id) . '">
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
            $all = Photo::count();
            $published = Photo::where('post_status','Published')->count();
            $draft = Photo::where('post_status','Draft')->count();
            $trash = Photo::onlyTrashed()->count();
        }else{
            $all = Photo::where('users_id', Auth::user()->id)->count();
            $published = Photo::where(['post_status' => 'Published', 'users_id' => Auth::user()->id])->count();
            $draft = Photo::where(['post_status'=>'Draft', 'users_id' => Auth::user()->id])->count();
            $trash = Photo::onlyTrashed()->count();
        }

        return view('pages.admin.photo.index',[
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
                $query = Photo::where('post_status','Published')->with(['user','category'])->latest()->get();
            }else{
                $query = Photo::where(['users_id' => Auth::user()->id, 'post_status' => 'Published'])->with(['user','category'])->latest()->get();
            }

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return Auth::user()->roles == 'Administrator'? '
                        <a class="btn btn-primary btn-xs" href="' . route('photo.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('photo.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ':'
                        <a class="btn btn-primary btn-xs" href="' . route('photo.edit', $item->id) . '">
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
            $all = Photo::count();
            $published = Photo::where('post_status','Published')->count();
            $draft = Photo::where('post_status','Draft')->count();
            $trash = Photo::onlyTrashed()->count();
        }else{
            $all = Photo::where('users_id', Auth::user()->id)->count();
            $published = Photo::where(['post_status' => 'Published', 'users_id' => Auth::user()->id])->count();
            $draft = Photo::where(['post_status'=>'Draft', 'users_id' => Auth::user()->id])->count();
            $trash = Photo::onlyTrashed()->count();
        }

        return view('pages.admin.photo.index',[
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
                $query = Photo::where('post_status','Draft')->with(['user','category'])->latest()->get();
            }else{
                $query = Photo::where(['users_id' => Auth::user()->id, 'post_status' => 'Draft'])->with(['user','category'])->latest()->get();
            }

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return Auth::user()->roles == 'Administrator'? '
                        <a class="btn btn-primary btn-xs" href="' . route('photo.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('photo.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ':'
                        <a class="btn btn-primary btn-xs" href="' . route('photo.edit', $item->id) . '">
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
            $all = Photo::count();
            $published = Photo::where('post_status','Published')->count();
            $draft = Photo::where('post_status','Draft')->count();
            $trash = Photo::onlyTrashed()->count();
        }else{
            $all = Photo::where('users_id', Auth::user()->id)->count();
            $published = Photo::where(['post_status' => 'Published', 'users_id' => Auth::user()->id])->count();
            $draft = Photo::where(['post_status'=>'Draft', 'users_id' => Auth::user()->id])->count();
            $trash = Photo::onlyTrashed()->count();
        }

        return view('pages.admin.photo.index',[
            'all' => $all,
            'published' => $published,
            'draft' => $draft,
            'trash' => $trash
        ]);
    }

    public function trash()
    {
        if (request()->ajax()) {
            $query = Photo::onlyTrashed()->with(['user','category'])->latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="btn btn-primary btn-xs" href="' . route('photo-restore', $item->id) . '">
                            <i class="fas fa-sync"></i> &nbsp; Kembalikan
                        </a>
                        <form action="' . route('photo-force-delete', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini secara permanen dari situs anda?'".')">
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

        $all = Photo::count();
        $published = Photo::where('post_status','Published')->count();
        $draft = Photo::where('post_status','Draft')->count();
        $trash = Photo::onlyTrashed()->count();

        return view('pages.admin.photo.index',[
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

        return view('pages.admin.photo.create',[
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
            'slug' => 'unique:photos',
            'post_source' => 'required',
            'post_photographer' => 'required',
            'post_caption' => 'required',
        ]);

        if($request->publish){
            $validatedData['post_status'] = 'Published';
        }else{
            $validatedData['post_status'] = 'Draft';
        }

        $validatedData['users_id'] = auth()->user()->id;
        $validatedData['slug'] = Str::slug($request->post_title);
        $validatedData['post_teaser'] = Str::limit(strip_tags($request->post_teaser), 140);

        $photo = Photo::create($validatedData);

        if($request->hasfile('photo')){
            $image = $request->file('photo');
            foreach($image as $file)
            {
                $gallery['photos'] = $file->store('assets/photo-gallery');
                $gallery['photos_id'] = $photo->id;

                PhotoGallery::create($gallery);
            }
        }

        $photo->tag()->attach($request->tags);

        return redirect()
                    ->route('photo.index')
                    ->with('success', 'Sukses! Data Berhasil Disimpan');
    }


    public function edit($id)
    {
        $item = Photo::with(['galleries'])->findOrFail($id);
        $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
        $sub_categories = Category::where('parent_id', $item->categories_id)->orderby('name', 'asc')->get();
        $tags = Tag::all();

        return view('pages.admin.photo.edit',[
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
            'post_content' => 'required',
            'post_source' => 'required',
            'post_photographer' => 'required',
            'post_caption' => 'required',
        ]);

        $item = Photo::findOrFail($id);

        if($request->publish){
            $validatedData['post_status'] = 'Published';
        }else{
            $validatedData['post_status'] = 'Draft';
        }

        $validatedData['users_id'] = auth()->user()->id;
        $validatedData['slug'] = Str::slug($request->post_title);
        $validatedData['post_teaser'] = Str::limit(strip_tags($request->post_teaser), 140);

        $item->update($validatedData);

        $item->tag()->sync($request->tags);

        return redirect()
                    ->route('photo.edit', $item->id)
                    ->with('success', 'Sukses! Data Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        $item = Photo::findorFail($id);

        $item->delete();

        return redirect()
                    ->route('photo.index')
                    ->with('success', 'Sukses! Data Berhasil Dihapus');
    }

    public function uploadGallery(Request $request)
    {
        $validatedData = $request->validate([
            'photos_id' => 'required',
            'photos' => 'required|image|file|max:1024',
        ]);

        if($request->file('photos')){
            $validatedData['photos'] = $request->file('photos')->store('assets/photo-gallery');
        }

        PhotoGallery::create($validatedData);
        return redirect()
                    ->route('photo.edit', $request->photos_id)
                    ->with('success', 'Sukses! Foto Berhasil Disimpan');
    }

    public function deleteGallery($id)
    {
        $item = PhotoGallery::findorFail($id);

        Storage::delete($item->photos);

        $item->delete();

        return redirect()
                    ->route('photo.edit', $item->photos_id)
                    ->with('success', 'Sukses! Foto Berhasil Dihapus');
    }

    public function force_delete($id)
    {
        $item = Photo::onlyTrashed()->findOrFail($id);  

        $gallery = PhotoGallery::where('photos_id', '=', $id)->get();
        foreach ($gallery as $row) {
            Storage::delete($row->photos);
        }
        
        $item->forceDelete();

        return redirect()
                    ->route('photo-trash')
                    ->with('success', 'Sukses! 1 Data dihapus secara permanen.');
    }

    public function restore_data($id)
    {
        Photo::withTrashed()->find($id)->restore();

        return redirect()
                    ->route('photo-trash')
                    ->with('success', 'Sukses! 1 Data berhasil dikembalikan dari sampah.');
    }
}
