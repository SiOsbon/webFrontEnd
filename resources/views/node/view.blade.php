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
                        <div class="row">
                            <div class="col-md-2"><strong>Node id</strong></div>
                            <div class="col-md-2"><strong>Node name</strong></div>
                            <div class="col-md-2"><strong>Registered</strong></div>
                            <div class="col-md-3"><strong>Total tasks executed</strong></div>
                            <div class="col-md-2"><strong>Location</strong></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                {{ $node['id'] }}
                            </div>
                            <div class="col-md-2">
                                {{ $node['name'] }}
                            </div>
                            <div class="col-md-2">
                                @php
                                    $timeInSec = $node['registeredAt'] / 1000;
                                @endphp
                                {{ date("Y-m-d H:i:s",$timeInSec) }}
                            </div>
                            <div class="col-md-3">
                                {{ $node['totalExecutedTasksCount'] }}
                            </div>
                            <div class="col-md-2">
                                {{ $node['location'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
        <div id="nodeTaskChart"></div>
        @columnchart('nodeTaskChart', 'nodeTaskChart')
                </div>
            </div>
    </div>
@endsection
