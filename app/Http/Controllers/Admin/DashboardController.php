<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->roles == 'Administrator' || Auth::user()->roles == 'Editor'){
            $draft = Post::where('post_status', 'Draft')->get()->count();
            $published = Post::where('post_status', 'Published')->get()->count();
            $user = User::count();
            $photo = Photo::count();
        }else{
            $draft = Post::where(['post_status' => 'Draft', 'users_id' => Auth::user()->id])->get()->count();
            $published = Post::where(['post_status' => 'Published', 'users_id' => Auth::user()->id])->get()->count();
            $user = User::count();
            $photo = Photo::where(['users_id' => Auth::user()->id])->get()->count();
        }

        $app = App::where('id', '1')->first();

        return view('pages.admin.dashboard',[
            'draft' => $draft,
            'published' => $published,
            'user' => $user,
            'photo' => $photo,
            'app' => $app,
        ]);
    }
}
