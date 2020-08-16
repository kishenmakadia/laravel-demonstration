@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          {{ request()->routeIs('categories.create') ? __('Add Category') : __('Update Category') }}
        </div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif

          <form method="POST"
            action="{{ request()->routeIs('categories.create') ? route('categories.store') : route('categories.update', ['category'=>$category]) }}">
            @csrf
            @if (request()->routeIs('categories.edit'))
            @method('patch')
            @endif

            <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                  value="{{ old('name', isset($category) ? $category->name : '' )}}" required autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <a class="btn btn-secondary" href="{{route('categories.index')}}">
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