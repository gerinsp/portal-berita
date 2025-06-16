<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Rules\MatchOldPassword;

class UserController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $query = User::latest()->get();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="btn btn-primary btn-xs" href="' . route('user.edit', $item->id) . '">
                            <i class="fas fa-edit"></i> &nbsp; Ubah
                        </a>
                        <form action="' . route('user.destroy', $item->id) . '" method="POST" onsubmit="return confirm('."'Anda akan menghapus item ini secara permanen dari situs anda?'".')">
                            ' . method_field('delete') . csrf_field() . '
                            <button class="btn btn-danger btn-xs">
                                <i class="far fa-trash-alt"></i> &nbsp; Hapus
                            </button>
                        </form>
                    ';
                })
                ->editColumn('name', function ($item) {
                    return $item->profile ? 
                                '<div class="d-flex align-items-center">
                                    <div class="avatar me-2"><img class="avatar-img img-fluid" src="'. Storage::url($item->profile) .'" /></div>'.
                                    $item->name .'
                                </div>' 
                            : 
                                '<div class="d-flex align-items-center">
                                    <div class="avatar me-2"><img class="avatar-img img-fluid" src="https://ui-avatars.com/api/?name='.$item->name.'" /></div>'.
                                    $item->name .'
                                </div>';
                })
                ->editColumn('pos', function ($item) {
                    $total_post = Post::where('users_id',$item->id)->get()->count();
                    return $total_post;
                })
                ->addIndexColumn()
                ->removeColumn('id')
                ->rawColumns(['action','name','pos'])
                ->make();
        }
        return view('pages.admin.user.index');
    }

    public function create()
    {
        return view('pages.admin.user.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255',
            'roles' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect()
                    ->route('user.index')
                    ->with('success', 'Sukses! Data Pengguna Berhasil Disimpan');
    }

    public function edit($id)
    {
        $item = User::findOrFail($id);

        return view('pages.admin.user.edit',[
            'item' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns',
            'roles' => 'required',
        ]);

        $item = User::findOrFail($id);

        if ($request->password) 
        {
        	$validatedData['password'] = bcrypt($request->password);
        } 
        else 
        {
        	unset($validatedData['password']);
        }
        
        $item->update($validatedData);

        return redirect()
                ->route('user.index')
                ->with('success', 'Sukses! Data Pengguna telah diperbarui');
    }

    public function destroy($id)
    {
        $item = User::findorFail($id);
        $item->delete();

        return redirect()
                ->route('user.index')
                ->with('success', 'Sukses! Data Pengguna telah dihapus');
    }

    public function show()
    {
        $user = Auth::user();

        return view('pages.admin.user.profile',[
            'user' => $user
        ]);
    }

    public function update_profile(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns',
        ]);

        $item = User::findOrFail($id);
        
        $item->update($validatedData);

        return redirect()
                ->route('profile-user')
                ->with('success', 'Sukses! Data Pengguna telah diperbarui');
    }

    public function upload_profile(Request $request)
    {
        $validatedData = $request->validate([
            'profile' => 'image|file|max:1024',
        ]);

        $id = $request->id;
        $item = User::findOrFail($id);

        if($request->file('profile')){
            Storage::delete($item->profile);
            $validatedData['profile'] = $request->file('profile')->store('assets/profile-images');
        }

        $item->update($validatedData);

        return redirect()
                ->route('profile-user')
                ->with('success', 'Sukses! Photo Pengguna telah diperbarui');
    }

    public function change_password()
    {
        return view('pages.admin.user.change-password');
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['min:5','max:255'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return redirect()
                ->route('change-password')
                ->with('success', 'Sukses! Password telah diperbarui');
    }
}
