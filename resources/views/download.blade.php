@extends('layouts.app')

@section('content')
<div class="container">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <div class="row flash-message flash-message-{{ $msg }} col-md-8 col-md-offset-2">
                {{ Session::get('alert-' . $msg) }}
            </div>
        @endif
    @endforeach
    <p></p>
    <div class="row">
        <div class="col-m-12">Download latest node application: <a href="/Daratus Node 0.0.6.zip" target="_blank">Daratus 0.0.6</a>
            <p></p>
            Node sources repository: <a href="https://github.com/daratus/node" target="_blank">https://github.com/daratus/node</a>
        </div>
    </div>
</div>
@endsection
