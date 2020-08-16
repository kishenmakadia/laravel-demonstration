@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          {{ request()->routeIs('users.create') ? __('Add User') : __('Update User') }}
        </div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif

          <form method="POST"
            action="{{ request()->routeIs('users.create') ? route('users.store') : route('users.update', ['user'=>$user]) }}">
            @csrf
            @if (request()->routeIs('users.edit'))
            @method('patch')
            @endif

            <div class="form-group row">
              <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

              <div class="col-md-6">
                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                  name="first_name" value="{{ old('first_name', isset($user) ? $user->first_name : '' )}}" required
                  autofocus>

                @error('first_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

              <div class="col-md-6">
                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                  name="last_name" value="{{ old('last_name', isset($user) ? $user->last_name : '' )}}" required>

                @error('last_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                  value="{{ old('email', isset($user) ? $user->email : '' )}}" required autocomplete="email"
                  {{ request()->routeIs('users.edit') ? 'disabled' : '' }}>

                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

              <div class="col-md-6">
                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                  value="{{ old('phone', isset($user) ? $user->phone : '' )}}" required
                  {{ request()->routeIs('users.edit') ? 'disabled' : '' }}>

                @error('phone')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            @if (request()->routeIs('users.create'))
            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                  name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="password-confirm"
                class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

              <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                  autocomplete="new-password">
              </div>
            </div>
            @endif

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <a class="btn btn-secondary" href="{{route('users.index')}}">
                  {{ __('Back') }}
                </a>
                <button type="submit" class="btn btn-primary">
                  {{ __('Save') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection