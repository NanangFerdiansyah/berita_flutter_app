<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;  
use App\Models\Post;

class FrontendController extends Controller
{
    public function index(){
        $all_categories = Category::where('status', '0')->get();
        $all_posts = Post::where('status', '0')->get();
        return view("frontend.index", compact("all_categories", "all_posts"));

    }

    public function viewCategoryPost(string $category_slug)
    {
        $category = Category::where('slug', $category_slug)->where('status', '0')->first();
        if($category){
            $post = Post::where('category_id', $category->id)->where('status', '0')->paginate(5);
            return view("frontend.post.index", compact('post','category'));
        }
        else{
            return redirect('/');
        }
      
    }

    public function viewPost(string $category_slug, string $post_slug)
    {
        $category = Category::where('slug', $category_slug)->where('status', '0')->first();
        if($category){
            $post = Post::where('category_id', $category->id)->where('slug', $post_slug)->where('status', '0')->first();
            $latest_post = Post::where('category_id', $category->id)->where('status', '0')->orderBy('created_at', 'DESC')->limit(5)->get();
            return view("frontend.post.view", compact('post','latest_post'));
        }
        else{
            return redirect('/');
        }

     }
}
