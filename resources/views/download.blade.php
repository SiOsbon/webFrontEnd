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
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        Download latest node application: <a href="/Daratus Node 0.0.5.zip" target="_blank">Daratus 0.0.5</a><br><br>
                        Node sources repository: <a href="https://github.com/daratus/node" target="_blank">https://github.com/daratus/node</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
