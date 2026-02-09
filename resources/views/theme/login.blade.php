@extends('theme.master')
@section('title', 'Login')

@section('content')

@include('theme.partials.hero', ['title' => 'Login'])
  

  <!-- ================ contact section start ================= -->
  <section class="section-margin--small section-margin">
    <div class="container">
      <div class="row">
        <div class="col-6 mx-auto">
          <form action="{{ route('login') }}" class="form-contact contact_form"  method="post"  novalidate="novalidate">
            @csrf
            <div class="form-group">
              <input class="form-control border" name="email" id="email" type="email" value="{{ old('email') }}" placeholder="Enter email address">
              @error('email')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <x-auth-session-status class="mb-4 text-success" :status="session('status')" />
            @if (config('verification.way') != 'passwordless')
            <div class="form-group">
              <input class="form-control border" name="password" id="name" type="password" value="{{ old('password') }}" placeholder="Enter your password">
              @error('password')
              <span class="text-danger">{{ $message }}</span>
            @enderror
            </div> 
            @endif
            <div class="form-group text-center text-md-right mt-3">
              <a href="{{ route('register') }} " class="mx-3">Instead register</a>
              <button type="submit" class="button button--active button-contactForm">Login</button>
            </div>
            <div class="form-group text-center  mt-3">
              <a href="{{ route('google.login') }}" class="button button--active button-contactForm">Login With Google</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
	<!-- ================ contact section end ================= -->

@endsection