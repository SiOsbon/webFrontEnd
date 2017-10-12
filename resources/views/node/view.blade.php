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
            <div class="col-m-2"><strong>Node id</strong></div>
            <div class="col-m-2"><strong>Node name</strong></div>
            <div class="col-m-3"><strong>Registered</strong></div>
            <div class="col-m-3"><strong>Total tasks executed</strong></div>
            <div class="col-m-2"><strong>Location</strong></div>
        </div>
        <div class="row">
            <div class="col-m-2">
                {{ $node['id'] }}
            </div>
            <div class="col-m-2">
                {{ $node['name'] }}
            </div>
            <div class="col-m-3">
                @php
                    $timeInSec = $node['registeredAt'] / 1000;
                @endphp
                {{ date("Y-m-d H:i:s",$timeInSec) }}
            </div>
            <div class="col-m-3">
                {{ $node['totalExecutedTasksCount'] }}
            </div>
            <div class="col-m-2">
                {{ $node['location'] }}
            </div>
        </div>
        <p></p>
        <div class="row">
            <div class="col-m-12">
            {{ Form::open(['route' => ['node', $node["id"]], 'method' => 'post', 'id' => 'filter-stats']) }}
            <div class="pull-left">
                {{ Form::label('interval', "Interval", ['class' => 'form-control-label']) }}
                {{ Form::select('interval', \AppHelper::instance()->getIntervalSelecValues(), $interval,
                ['onchange' => "event.preventDefault(); document.getElementById('filter-stats').submit();"]) }}
                @if ($errors->has('interval'))
                    <div class="error-message">
                    <span>
                        <strong>{{ $errors->first('interval') }}</strong>
                    </span>
                    </div>
                @endif
            </div>
            <div class="pull-right">
                {{ Form::label('period', "Period", ['class' => 'form-control-label']) }}
                {{ Form::select('period', \AppHelper::instance()->getPeriodSelectValues(), $period,
                    ['onchange' => "event.preventDefault(); document.getElementById('filter-stats').submit();"]) }}
                @if ($errors->has('period'))
                    <div class="error-message">
                <span>
                    <strong>{{ $errors->first('period') }}</strong>
                </span>
                    </div>
                @endif
            </div>
            {{ Form::close() }}
            </div>
        </div>
        <p></p>
        <div class="row">
            <div id="nodeTaskChart"></div>
            @columnchart('nodeTaskChart', 'nodeTaskChart')
        </div>
    </div>
@endsection
