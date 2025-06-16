<?php

namespace App\Http\Controllers;

use App\Models\Headline;
use App\Models\BreakingNews;
use App\Models\Post;
use App\Models\Category;
use App\Models\HeadlineCategory;
use App\Models\User;
use App\Models\Photo;
use App\Models\PostTag;
use App\Models\Tag;
use App\Models\Redaction;
use App\Models\Disclaimer;
use App\Models\Guideline;
use App\Models\Contact;
use App\Models\BreakingNewsCategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $post = Post::with(['user','category'])->where([
            ['post_status','=', 'Published'],
            ['published_at','<', now()],
        ])->latest()->paginate(3);

        $breaking_news = BreakingNews::with(['post'])->latest()->get();
        $headlines = Headline::with(['post'])->latest()->get();
        $gadget = Post::with(['user','category'])->where([
            ['categories_id','=' , 3],
            ['post_status','=' , 'Published'],
            ['published_at','<', now()],
        ])->take(6)->latest()->get();
        $games = Post::with(['user','category'])->where([
            ['categories_id','=' , 5],
            ['post_status','=' , 'Published'],
            ['published_at','<', now()],
        ])->take(8)->latest()->get();
        $tutorials = Post::with(['user','category'])->where([
            ['categories_id','=' , 13],
            ['post_status','=' , 'Published'],
            ['published_at','<', now()],
        ])->latest()->get();

        return view('pages.home.index',[
            'post' => $post,
            'breaking_news' => $breaking_news,
            'headlines' => $headlines,
            'gadget' => $gadget,
            'games' => $games,
            'tutorials' => $tutorials
        ]);
    }

    public function autocomplete(Request $request)
    {
        $data = $request->all();

        $query = $data['query'];

        $filter_data = Post::select('post_title')
                        ->where([
                            ['post_title', 'LIKE', '%'.$query.'%'],
                            ['post_status','=', 'Published'],
                            ['published_at','<', now()],
                        ])
                        ->pluck('post_title');

        return response()->json($filter_data);
    }

    public function searchArticle(Request $request)
    {
        $post = Post::with(['user','category'])
                        ->where('post_title', $request->keyword)
                        ->orWhere('post_title', 'like','%'.$request->keyword.'%')
                        ->paginate(6);
        $count = Post::with(['user','category'])->where('post_title', $request->keyword)->orWhere('post_title', 'like','%'.$request->keyword.'%')->count();
        $latest_post = Post::with(['user','category'])->where([
                            ['post_status','=', 'Published'],
                            ['published_at','<', now()],
                        ])->take(6)->latest()->get();

        return view('pages.home.search',[
            'post' => $post,
            'keyword' => $request->keyword,
            'count' => $count,
            'latest_post' => $latest_post
        ]);

    }

    public function detail($slug)
    {
        $post = Post::with(['user','category'])->where('slug',$slug)->firstOrFail();
        
        $latest_post = Post::with(['user','category'])->where([
            ['post_status','=', 'Published'],
            ['published_at','<', now()],
        ])->take(6)->latest()->get();
        $related_post = Post::with(['user','category'])->where([
            ['users_id','=', $post->users_id],
            ['post_status','=' , 'Published'],
            ['published_at','<', now()],
        ])->take(3)->latest()->get();

        if ($post->sub_categories != NULL) {
            $sc = Category::where('id', $post->sub_categories)->firstOrFail();
        }else{
            $sc = '';   
        }

        return view('pages.home.detail',[
            'post' => $post,
            'sc' => $sc,
            'latest_post' => $latest_post,
            'related_post' => $related_post
        ]);
    }

    public function homeCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $headline = HeadlineCategory::with(['post'])->where('category_id', $category->id)->latest()->get();
        
        $post = Post::with(['user','category'])->where([
            ['categories_id','=', $category->id],
            ['post_status','=' , 'Published'],
            ['published_at','<', now()],
        ])->orWhere('sub_categories', '=', $category->id)
        ->latest()->paginate(6);

        $latest_post = Post::with(['user','category'])->where([
            ['post_status','=' , 'Published'],
            ['published_at','<', now()],
        ])->take(4)->latest()->get();
    
        return view('pages.home.category',[
            'category' => $category,
            'post' => $post,
            'latest_post' => $latest_post,
            'headline' => $headline
        ]);
    }

    public function homeTag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();        
        
        $post_tag = DB::table('post_tag')
            ->join('posts', 'post_tag.post_id', '=', 'posts.id')
            ->join('categories', 'posts.categories_id', '=', 'categories.id')
            ->join('tags', 'post_tag.tag_id', '=', 'tags.id')
            ->join('users', 'posts.users_id', '=', 'users.id')
            ->select('posts.post_title', 'posts.post_teaser', 'posts.post_image', 'posts.slug', 'posts.published_at', 'categories.name as category', 'categories.slug as category_slug', 'tags.name', 'users.name as author')
            ->where('post_tag.tag_id', $tag->id)
            ->where('posts.published_at','<', now())
            ->get();

        $latest_post = Post::with(['user','category'])->where([
            ['post_status','=' , 'Published'],
            ['published_at','<', now()],
        ])->take(4)->latest()->get();
        
        return view('pages.home.tag',[
            'tag' => $tag,
            'post_tag' => $post_tag,
            'latest_post' => $latest_post,
        ]);
    }

    public function images()
    {
        $post = Photo::with(['user','category','galleries'])->where('post_status', 'Published')->latest()->paginate(6);

        $latest_post = Post::with(['user','category'])->where('post_status', 'Published')->take(4)->latest()->get();
        
        return view('pages.home.images',[
            'post' => $post,
            'latest_post' => $latest_post,
        ]);
    }

    public function detail_images($slug)
    {
        $post = Photo::with(['user','category'])->where('slug',$slug)->firstOrFail();
        
        $latest_post = Post::with(['user','category'])->where('post_status', 'Published')->take(6)->latest()->get();
        $related_post = Post::with(['user','category'])->where([
            ['users_id','=',$post->users_id],
            ['post_status','=' , 'Published']
        ])->take(3)->latest()->get();

        return view('pages.home.detail-images',[
            'post' => $post,
            'latest_post' => $latest_post,
            'related_post' => $related_post
        ]);
    }

    public function author($id)
    {
        $user = User::findOrFail($id);

        $post = Post::with(['user','category'])->where([
            ['users_id','=', $user->id],
            ['post_status','=' , 'Published'],
            ['published_at','<', now()],
        ])->latest()->paginate(3);

        $latest_post = Post::with(['user','category'])->where([
            ['post_status','=' , 'Published'],
            ['published_at','<', now()],
        ])->take(6)->latest()->get();
        
        return view('pages.home.author',[
            'user' => $user,
            'latest_post' => $latest_post,
            'post' => $post,
        ]);
    }

    public function redaksi()
    {
        $item = Redaction::first();

        return view('pages.home.redaksi', [
            'item' => $item
        ]);
    }

    public function pedoman()
    {
        $item = Guideline::first();

        return view('pages.home.pedoman', [
            'item' => $item
        ]);
    }

    public function disclaimer()
    {
        $item = Disclaimer::first();

        return view('pages.home.disclaimer', [
            'item' => $item
        ]);
    }

    public function kontak()
    {
        $item = Contact::first();

        return view('pages.home.contact', [
            'item' => $item
        ]);
    }
}
