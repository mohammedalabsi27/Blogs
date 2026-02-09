@extends('theme.master')
@section('title', 'Verify OTO')

@section('content')

@include('theme.partials.hero', ['title' => 'Please Verify yout OTP'])
  

  <!-- ================ contact section start ================= -->
  <section class="section-margin--small section-margin">
    <div class="container">
      <div class="row">
        <div class="col-6 mx-auto">
          <form action="{{ route('verifyOTP') }}" class="form-contact contact_form"  method="post"  novalidate="novalidate">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <div class="form-group">
              <input class="form-control border" name="otp" id="otp" type="otp"  placeholder="Enter yout OTP">
              @error('otp')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <x-auth-session-status class="mb-4 text-success" :status="session('status')" />
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