@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Article') }}</div>

                <div class="card-body">
                    <form action="{{ route('articles.update', $article->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        Title:
                        <br />
                        <input type="text" name="title" class="form-control" value="{{ $article->title }}" />
                        <br />

                        Full text:
                        <br />
                        <textarea class="form-control" rows="10" name="full_text">{{ $article->full_text }}</textarea>
                        <br />

                        Category:
                        <br />
                        <select class="form-control" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                        @if ($category->id == $article->category_id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <br />

                        {{--1. is_publisher an is_admin is created as function in user model. App\Models\User
                            function name =getIsAdminAttribute and getIsPublisherAttribute
                            then we created control here as per the user model function.
                            --}}
                            
                        {{-- @if(auth()->user()->is_publisher || auth()->user()->is_admin)  --}}
                        @can('publish-articles')
                        {{-- 2.after we used gate we started to use can on the frontend. Publish-article define at app\Providers\AuthServiceProvider.php --}}

                        <input type="checkbox" name="published" value="1"> Published
                        @endcan
                        {{-- @endif --}}
                        <br>
                        <br>
                        <input type="submit" value=" Update Article " class="btn btn-primary" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
