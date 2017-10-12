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
            <div class="col-m-12"><h2>All nodes</h2></div>
        </div>
        <div class="row">
            <div class="col-m-2"><strong>Node id</strong></div>
            <div class="col-m-2"><strong>Name</strong></div>
            <div class="col-m-3"><strong>Task executed count</strong></div>
            <div class="col-m-2"><strong>Location</strong></div>
            <div class="col-m-3"><strong>Registered</strong></div>
        </div>
        @foreach($nodes as $node)
            <div class="row">
                <div class="col-m-2">
                    <a href="{{ route('node', ['nodeId' => $node['id']]) }}"> {{ $node['id'] }}</a>
                </div>
                <div class="col-m-2">
                    {{ $node['name'] }}
                </div>
                <div class="col-m-3">
                    {{ $node['totalExecutedTasksCount'] }}
                </div>
                <div class="col-m-2">
                    {{ $node['location'] }}
                </div>
                <div class="col-m-3">
                    @php
                        $timeInSec = $node['registeredAt'] / 1000;
                    @endphp
                    {{ date("Y-m-d H:i:s",$timeInSec) }}
                </div>
            </div>
        @endforeach
    </div>
@endsection
