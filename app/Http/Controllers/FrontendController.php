<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class FrontendController extends Controller
{
    public function index() {
        $gallery = Post::where('carousel',1)->orderByDesc('date')->get();
        $posts = Post::where('status',1)->orderByDesc('updated_at')->get(); //according to date
        $featured_posts = Post::where('featured',1)->orderByDesc('date')->get();
        $cat = Category::where('status',1)->get();
        return view('frontend.index',compact('posts','cat','featured_posts','gallery'));
    }

    public function search(Request $request){
        $cat = Category::where('status',1)->get();
        if($request->input('search') == null){
            return redirect()->back();
        }
        else{
        $postsQuery = Post::query();
        // For Search
        $search = $request->input('search');
        if ($search) {
            $postsQuery->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('author', 'like', '%' . $search . '%');
            });
        }
        $posts = $postsQuery->orderByDesc('updated_at')->get();
        }
        return view('frontend.searchresults',compact('cat','posts'));
    }

    public function about(){
        $cat = Category::where('status',1)->get();
        return view('frontend.about',compact('cat'));
    }

    public function post($id){
        $posts = Post::find($id);
        $cat = Category::where('status',1)->get();
        if (!$posts) {
        return redirect()->back(); // Redirect to the home page if the blog doesn't exist
        }
        return view('frontend.post',compact('posts','cat'));
    }

    public function showcat(Request $request, $category){
        $cat = Category::where('status', 1)->get();
        $category = Category::where('name', $category)->first();
        if (!$category) {
        return redirect()->back(); // Redirect to the home page if the category doesn't exist
        }
        // Fetch posts based on the selected category or all posts if no category selected
        $postsQuery = $category ? $category->posts() : Post::query();
        // For Search
        $search = $request->input('search');
        if ($search) {
            $postsQuery->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('author', 'like', '%' . $search . '%');
            });
        }
        $posts = $postsQuery->orderByDesc('updated_at')->paginate(9);
        return view('frontend.posts_with_cat', compact('posts', 'category', 'cat', 'search'));
    }

    public function showmoreposts() {
        //we use ajax call to show a list of posts excluding the first three posts
        $firstFourPostIds = Post::where('featured', 1)->orderByDesc('date')->take(4)->pluck('id')->toArray();
        // Fetch the featured posts excluding the first 3 posts
        $moreposts = Post::where('featured', 1)->orderByDesc('updated_at')->whereNotIn('id', $firstFourPostIds)->get();
        return view('frontend.moreposts', compact('moreposts'));
    }

    public function showmorepops() {
        //we use ajax call to show a list of posts excluding the first three posts
        $firstFourPostIds = Post::where('status', 1)->orderByDesc('updated_at')->take(4)->pluck('id')->toArray();
        // Fetch the featured posts excluding the first 3 posts
        $moreposts = Post::where('status', 1)->orderByDesc('updated_at')->whereNotIn('id', $firstFourPostIds)->get();
        return view('frontend.morepops', compact('moreposts'));
    }
    
    public function showpostslug($slug){
        $posts = Post::where('slug', $slug)->firstOrFail();
        $cat = Category::where('status',1)->get();
        if (!$posts) {
        return redirect()->back();
        }
        return view('frontend.post', compact('posts','cat'));
    }
}
