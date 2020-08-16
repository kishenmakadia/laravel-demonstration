@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        {{ __('Products') }}
                    </h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ __('List of all the products.') }}</h6>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="mb-4">
                        <a class="btn btn-primary" href="{{route('products.create')}}">{{ __('Add product') }}</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Slug') }}</th>
                                    <th>{{ __('Categories') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                <tr>
                                    <td>
                                        <a href="{{route('products.edit',['product' => $product])}}">
                                            {{$product->name}}
                                        </a>
                                    </td>
                                    <td>
                                        {{$product->slug}}
                                    </td>
                                    <td>{{$product->categories->count() ? $product->categories->implode('name', ', ') : '-'}}
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{route('products.destroy', ['product' => $product])}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <svg width="1.25em" height="1.25em" viewBox="0 0 16 16"
                                                    class="bi bi-trash" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                    <path fill-rule="evenodd"
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr class="text-center">
                                    <td colspan="3">No products added</td>
                                </tr>

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection