@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <img src="https://via.placeholder.com/420x200" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ strlen($property->description) > 30? substr($property->description, 0, 30) . '..' :$property->description  }}</h5>
                        <h5 class="card-title text-success">${{ $property->price }}</h5>
                        <p class="card-text">
                            <b>Number of Bedrooms:</b> {{ $property->number_of_bedrooms }}<br>
                            <b>Property Type:</b> {{ $property->propertyType->title }}<br>
                            <b>Type:</b> {{ ucfirst($property->type) }}<br>
                        </p>
                        <p class="card-text">{{ $property->description }}</p>
                        <p class="card-text"><small class="text-muted">{{ $property->created_at->diffForHumans() }}</small></p>
                        @auth()
                            <form action="{{route('property.delete', ['id' => $property->id])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary">Delete</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
