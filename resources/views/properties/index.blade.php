@extends('layouts.master')
@section('content')
    <h1>Properties</h1>
    @foreach($properties as $property)
        <h3>{{ $property->description }}</h3>
    @endforeach
@endsection
