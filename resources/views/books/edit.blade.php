@extends('layouts.app')

@section('content')
<section class="container">
    <div class="card">
        <div class="card-header">
            <a href="{{ url()->previous() }}"><button class="btn btn-sm btn-success mr-4"><i class="fa fa-arrow-left"></i> Back</button></a>
            <h5 class="mt-2">{{ $title }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('books.update',$book) }}" method="POST">
                @csrf
                @method("PUT")
                @include('books.form-control')
                <button type="submit" class="btn btn-primary">{{ $action }}</button>
            </form>
        </div>
    </div>  
</section>

@endsection