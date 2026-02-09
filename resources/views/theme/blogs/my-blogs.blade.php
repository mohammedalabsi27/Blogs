@extends('theme.master')
@section('title', 'My Blogs')

@section('content')

@include('theme.partials.hero', ['title' => 'My Blogs'])
  

  <!-- ================ contact section start ================= -->
  <section class="section-margin--small section-margin">
    <div class="container">
      <div class="row">
        <div class="col-12">
            @if (session('blogDeleteStatus'))
              <div class="alert alert-success">
                {{ session('blogDeleteStatus') }}
              </div>
            @endif
          <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col" width="15%">Actions</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
              @if (count($blogs))
                  @foreach ($blogs as $key => $blog)
                    <tr>
                      <td>{{ ++$key }}</td>
                      {{-- @php
                        $slug = Illuminate\Support\Str::slug($blog->name, '-');
                      @endphp --}}
                      <td><a href="{{ route('blogs.show', $blog) }}">{{ $blog->name }}</a></td>
                      <td>
                        <a href="{{ route('blogs.edit', $blog) }}" target="_blank" class="btn  btn-primary mr-2">Edit</a>
                        <form action="{{ route('blogs.destroy', $blog) }}" method="post" class="d-inline">
                          @csrf
                          @method('delete')
                            <button id="btn" type="submit" class="btn btn-danger">Delete</button>
                        </form>

                      </td>
                    </tr>
                  @endforeach
              @endif
            </tbody>
          </table>
          @if (count($blogs))
          {{ $blogs->render('pagination::bootstrap-4') }}
          @endif

        </div>
      </div>
    </div>
  </section>
	<!-- ================ contact section end ================= -->
    <script>
      let btn = document.querySelectorAll('button#btn');
      btn.forEach(bt=>{
      bt.addEventListener('click', function(){
      let dd = confirm('Do you want to delete this blog');
      if(dd == true){
        bt.type = "submit";
      }else{
      bt.type = "reset";
      }   
    })
  }) 
    </script>
@endsection