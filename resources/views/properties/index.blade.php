@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-3">
                <h3 >Properties</h3>
            </div>
            @foreach($properties as $property)
                <div class="col-md-3">
                    <div class="card mb-3">
                        <img src="https://via.placeholder.com/420x200" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <h5 class="card-title">${{ $property->price }}</h5>
                            <p class="card-text">{{ $property->description }}</p>
                            <p class="card-text"><small class="text-muted">{{ $property->created_at->diffForHumans() }}</small></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
