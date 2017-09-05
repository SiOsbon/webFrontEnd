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
                    <div class="panel-heading">Data contract details</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">Id</div>
                            <div class="col-md-6">{{ $dataContract['id'] }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">Name</div>
                            <div class="col-md-6">{{ $dataContract['name'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
