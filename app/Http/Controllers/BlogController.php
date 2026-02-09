<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBlogRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth')->only(['create']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::check()){
            $categories = Category::get();
            return view('theme.blogs.create', compact('categories'));
        }
        abort(403);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['name'], '-');

        $image = $request->image;

        $newImageName = time() . '-' . $image->getClientOriginalName();

        $image->storeAs('blogs', $newImageName, 'public');

        $data['image'] = $newImageName;
        $data['user_id'] = Auth::user()->id;
        
        Blog::create($data);

        return back()->with('blogCreateStatus', 'Your blog created Successfully ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('theme.single-blog', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        if($blog->user_id == Auth::user()->id){
            $categories = Category::get();
            return view('theme.blogs.edit', compact('blog', 'categories'));
        }
        abort(403);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        if($blog->user_id == Auth::user()->id){
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name'], '-');
 
            if($request->hasFile('image')){
    
                Storage::delete("public/blogs/$blog->image");
    
                $image = $request->image;
    
                $newImageName = time() . '-' . $image->getClientOriginalName();
    
                $image->storeAs('blogs', $newImageName, 'public');
    
                $data['image'] = $newImageName;
            }
             
            $blog->update($data);
    
            return back()->with('blogUpdateStatus', 'Your blog updated Successfully ');
        }
        abort(403);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if($blog->user_id == Auth::user()->id){
            Storage::delete("public/blogs/$blog->image");
            $blog->delete();
            return back()->with('blogDeleteStatus', 'Your blog has been deleted Successfully ');
        }
        abort(403);


    }

    public function myBlogs(){

        if(Auth::check()){
        $blogs = Blog::where('user_id', Auth::user()->id)->paginate(8);
        return view('theme.blogs.my-blogs', compact('blogs'));
        }
        abort(403);
    }
}
