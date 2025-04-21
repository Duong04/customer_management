@extends('layouts.auth-layout', ['title' => 'Đăng nhập'])
@section('content')
<div class="card">
    <div class="card-body">
      <!-- Logo -->
      <div class="app-brand justify-content-center">
        <a href="index.html" class="app-brand-link gap-2 mx-auto">
          <span class="app-brand-logo demo">
            <img src="/ibpo_logo.svg" alt="" width="60%" class="mx-auto">
          </span>
        </a>
      </div>
      <!-- /Logo -->
      <h4 class="mb-2">Welcome to iBPO! 👋</h4>
      <p class="mb-4">Vui lòng đăng nhập vào tài khoản của bạn và bắt đầu cuộc phiêu lưu</p>

      <form id="formAuthentication" class="mb-3 pb-2" action="{{ route('action.login') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input
            type="text"
            class="form-control"
            id="email"
            value="{{ old('email') }}"
            name="email"
            placeholder="Enter your email"
            autofocus
          />
          @if ($errors->first('email'))
              <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('email') }}</span>
          @endif
        </div>
        <div class="mb-3 form-password-toggle">
          <label for="password" class="form-label">Mật khẩu</label>
          <div class="input-group input-group-merge">

            <input
              type="password"
              id="password"
              value="{{ old('password') }}"
              class="form-control"
              name="password"
              placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
              aria-describedby="password"
            />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
          </div>
          @if ($errors->first('password'))
          <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('password') }}</span>
          @endif
        </div>
        <div class="mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember-me" />
            <label class="form-check-label" for="remember-me"> Lưu mật khẩu </label>
          </div>
        </div>
        <div class="mb-3">
          <button class="btn btn-primary d-grid w-100" type="submit">Đăng nhập</button>
        </div>
      </form>
    </div>
  </div>
@endsection