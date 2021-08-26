@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-3">
                <h3 >Properties</h3>
            </div>
            <div class="col-md-12">
                <p>
                    <a class="btn btn-primary" data-toggle="collapse" href="#searchForm" role="button" aria-expanded="false" aria-controls="searchForm">
                        Filter
                    </a>
                </p>
                <div class="collapse mb-5" id="searchForm">
                    <div class="card card-body">
                        <form action="{{route('property.filter')}}" method="GET">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="description">Name</label>
                                    <input type="text" class="form-control" name="description" id="description" value="{{ $filters['description']?? "" }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="number_of_bedrooms">Number of Bedrooms</label>
                                    <input type="number" class="form-control" name="number_of_bedrooms" id="number_of_bedrooms" value="{{ $filters['number_of_bedrooms']?? "0" }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control" name="price" id="price" value="{{ $filters['price'] ?? "0"}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="property_type">Property Type</label>
                                    <select class="custom-select" name="property_type" id="property_type">
                                        <option {{!isset($filters['property_type'])? "selected": ''}} value="">Choose...</option>
                                        @foreach($propertyTypes as $propertyType)
                                            <option {{ isset($filters['property_type']) && $filters['property_type'] == $propertyType->id ? "selected": "" }} value="{{ $propertyType->id }}">{{ strlen($propertyType->title) > 20? substr($propertyType->title, 0, 20) . '..': $propertyType->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="type">Type</label>
                                    <select class="custom-select" name="type" id="type">
                                        <option {{ !isset($filters['type'])? "selected": "" }} value="">Choose...</option>
                                        <option {{ isset($filters['type']) && $filters['type'] === 'sale'? "selected": "" }} value="sale">For Sale</option>
                                        <option {{ isset($filters['type']) && $filters['type'] === 'rent'? "selected": "" }} value="rent">For Rent</option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>
            @foreach($properties as $property)
                <div class="col-md-3">
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
                            <a href="{{ route('property.show', ['id' => $property->id]) }}" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
            @if(!count($properties))
                <div class="col-md-12 text-center">
                    <p class="text-warning">No properties found that match your search criteria!</p>
                </div>
            @endif
        </div>
        {{ $properties->links() }}
    </div>
@endsection
