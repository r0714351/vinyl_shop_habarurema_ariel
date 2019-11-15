@extends('layouts.template')

@section('title', 'Alt Shop')

@section('main')
    <h1>Shop - alternative listing</h1>

    @foreach($genres as $genre)
        <h2> {{$genre->name}}</h2>
        <ul>
            @foreach($genre->records as $record)
                <li><a href="../shop/{{$record->genre_id}}">{{$record->artist }} - {{$record->title}}</a> | Price: €{{$record->price}} |
                    Stock: {{$record->stock}}</li>
            @endforeach
        </ul>
    @endforeach
@endsection

