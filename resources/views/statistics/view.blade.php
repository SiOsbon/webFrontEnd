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
            <div class="col-m-12"><h2>System status</h2></div>
        </div>
        <div class="row">
            <div class="col-m-4"><strong>Nodes registered</strong></div>

            <div class="col-m-2">{{ (array_key_exists("registeredNodesCount", $statistics) ? $statistics["registeredNodesCount"] : '') }}</div>
        </div>
        <div class="row">
            <div class="col-m-4"><strong>Total data contracts</strong></div>
            <div class="col-m-2">{{ (array_key_exists("dataContractsCount", $statistics) ? $statistics["dataContractsCount"] : '') }}</div>
        </div>
        <div class="row">
            <div class="col-m-4"><strong>Data contracts running</strong></div>
            <div class="col-m-2">{{ (array_key_exists("activeDataContractsCount", $statistics) ? $statistics["activeDataContractsCount"] : '') }}</div>
        </div>
        <p></p>
            <div class="row">
                <div class="col-m-12">
                    {{ Form::open(['route' => 'statistics', 'method' => 'post', 'id' => 'filter-stats']) }}
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
            <div class="col-m-12">
                <div id="dataContractChart"></div>
                @columnchart('dataContractChart', 'dataContractChart')
            </div>
        </div>
            <p></p>
        <div class="row">
            <div class="col-m-12">
                <div id="nodeCountChart"></div>
                @columnchart('nodeCountChart', 'nodeCountChart')
            </div>
        </div>
        <p></p>
        <div class="row">
            <div class="col-m-12">
                <div id="taskResultsChart"></div>
                @columnchart('taskResultsChart', 'taskResultsChart')
            </div>
        </div>
    </div>
@endsection
