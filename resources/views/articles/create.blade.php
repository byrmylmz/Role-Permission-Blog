@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('New Article') }}</div>

                <div class="card-body">
                    <form action="{{ route('articles.store') }}" method="POST">
                        @csrf

                        Title:
                        <br />
                        <input type="text" name="title" class="form-control" />
                        <br />

                        Full text:
                        <br />
                        <textarea class="form-control" rows="10" name="full_text"></textarea>
                        <br />

                        Category:
                        <br />
                        <select class="form-control" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        {{-- is_publisher an is_admin is created as function in user model. App\Models\User
                            function name =getIsAdminAttribute and getIsPublisherAttribute
                            then we created control here as per the user model function.
                            
                            *After control created here we need to create control in articleController create function due to allow the data entry 
                            according to publisher and admin.
                            --}}
                            
                        {{-- @if(auth()->user()->is_publisher || auth()->user()->is_admin) --}}
                        @can('publish-articles') 
                        {{-- publish article define at app\Providers\AuthServiceProvider.php --}}
                        <input type="checkbox" name="published" value="1"> Published
                        @endcan
                        {{-- @endif --}}
                        <br />
                        <br>
                        <input type="submit" value=" Save Article " class="btn btn-primary" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection