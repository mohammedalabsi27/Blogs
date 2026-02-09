@extends('theme.master')
@section('title', 'Edit Blog')

@section('content')

@include('theme.partials.hero', ['title' => $blog->name])
  

  <!-- ================ contact section start ================= -->
  <section class="section-margin--small section-margin">
    <div class="container">
      <div class="row">
        <div class="col-12">
          @if (session('blogUpdateStatus'))
            <div class="alert alert-success">
              {{ session('blogUpdateStatus') }}
            </div>
          @endif
          <form action="{{ route('blogs.update', $blog) }}" class="form-contact contact_form"  method="POST"  novalidate="novalidate" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input class="form-control border" name="name"  type="text" placeholder="Enter your blog title" value="{{ $blog->name }}">
                {{-- <x-input-error :messages="$errors->get('name')" class="mt-2" /> --}}
                  @error('name')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
            </div>
            <div class="form-group">
                <input class="form-control border" name="image"  type="file" >
                {{-- <x-input-error :messages="$errors->get('name')" class="mt-2" /> --}}
                  @error('image')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
            </div>
            <div class="form-group">
                <select class="form-control border" name="category_id">
                    <option value="">Select Category</option>
                    @if (count($categories))
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($category->id == $blog->category_id)  >{{ $category->name }}</option>
                        @endforeach
                    @endif
                </select>
                {{-- <x-input-error :messages="$errors->get('name')" class="mt-2" /> --}}
                  @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
            </div>
            <div class="form-group">
                <textarea class="form-control different-control w-100" name="description" id="description" cols="30" rows="5" placeholder="Enter your blog description">{{ $blog->description }}</textarea>
                @error('description')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group text-center text-md-right mt-3">
              <button type="submit" class="button button--active button-contactForm">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
	<!-- ================ contact section end ================= -->

@endsection