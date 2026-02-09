<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index(){
        $blogs = Blog::latest()->paginate(4);
        $sliderBlogs = Blog::latest()->take(5)->get();
        return view('theme.index', compact('blogs', 'sliderBlogs'));
    }

    public function category(Category $category){
        $categoryName = $category->name;
        $blogs = Blog::where('category_id', $category->id)->paginate(8);
        return view('theme.category', compact('blogs', 'categoryName'));
    }

    public function contact(){
        return view('theme.contact');
    }

    // public function singleBlog(){
    //     return view('theme.single-blog');
    // }

    // public function login(){
    //     return view('theme.login');
    // }

    // public function register(){
    //     return view('theme.register');
    // }
}
