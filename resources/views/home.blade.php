@extends('layouts.app')
@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row">
    @foreach ($list as $item)
        <a href="./database/{{ $item->symbol }}" class="col-xs-6 col-md-3">
            <div class="thumbnail">
                <img src="expansion-{{ $item->symbol }}.png" alt="{{ $item->name }}">
                <div class="caption">
                    <h5>{{ $item->name }}</h5>
                    <p><small>{{ $item->releaseDate }}</small></p>
                </div>
            </div>
        </a>
    @endforeach
    </div>
</div>
@endsection
