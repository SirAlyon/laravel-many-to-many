@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header fw-bold">{{ __('You are logged in!') }}</div>

                <div class="card-body">
                    @include('partials.success')
                    
                    
                    <div>
                        <span>Review Posts:</span>
                        <a href="{{route('admin.posts.index')}}" class="btn btn-primary mx-2">SHOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



