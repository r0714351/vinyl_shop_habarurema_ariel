@extends('layouts.template')
@section('title', 'Records')

@section('main')
    <ul>
        @foreach ($records as $record)
            <li>{{ $record }}</li>
        @endforeach
    </ul>
@endsection
