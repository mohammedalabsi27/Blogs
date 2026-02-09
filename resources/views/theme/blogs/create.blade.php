@extends('theme.master')
@section('title', 'Add New Blog')

@section('content')

@include('theme.partials.hero', ['title' => 'Add New Blog'])
  

  <!-- ================ contact section start ================= -->
  <section class="section-margin--small section-margin">
    <div class="container">
      <div class="row">
        <div class="col-12">
          @if (session('blogCreateStatus'))
            <div class="alert alert-success">
              {{ session('blogCreateStatus') }}
            </div>
          @endif
          <form action="{{ route('blogs.store') }}" class="form-contact contact_form"  method="POST"  novalidate="novalidate" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input class="form-control border" name="name"  type="text" placeholder="Enter your blog title" value="{{ old('name') }}">
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
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @endif
                </select>
                {{-- <x-input-error :messages="$errors->get('name')" class="mt-2" /> --}}
                  @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
            </div>
            <div class="form-group">
                <textarea class="form-control different-control w-100" name="description" id="description" cols="30" rows="5" placeholder="Enter your blog description">{{ old('description') }}</textarea>
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