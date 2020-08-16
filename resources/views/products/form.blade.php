@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          {{ request()->routeIs('products.create') ? __('Add Product') : __('Update Product') }}
        </div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif

          <form method="POST"
            action="{{ request()->routeIs('products.create') ? route('products.store') : route('products.update', ['product'=>$product]) }}">
            @csrf
            @if (request()->routeIs('products.edit'))
            @method('patch')
            @endif

            <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                  value="{{ old('name', isset($product) ? $product->name : '' )}}" required autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="categories" class="col-md-4 col-form-label text-md-right">{{ __('Categories') }}</label>

              <div class="col-md-6">
                @foreach ($categories as $key => $category)
                <div class="form-check">
                  <input type="checkbox" name="categories[]" id="category_{{$key}}" value="{{$category->id}}"
                    class="form-check-input"
                    {{ isset($errors) && $errors->has('categories') ? null : isset($product) ? $product->categories->contains($category) ? 'checked' : null : null }}>
                  <label class="form-check-label" for="category_{{$key}}">{{$category->name}}</label>
                </div>
                @endforeach


                @error('categories')
                <input type="hidden" class="is-invalid">
                <div class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </div>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <a class="btn btn-secondary" href="{{route('products.index')}}">
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