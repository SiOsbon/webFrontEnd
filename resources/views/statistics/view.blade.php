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
                    <div class="panel-heading">System statistics</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4"><strong>Nodes registered</strong></div>

                            <div class="col-md-2">{{ (array_key_exists("registeredNodesCount", $statistics) ? $statistics["registeredNodesCount"] : '') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Total data contracts</strong></div>
                            <div class="col-md-2">{{ (array_key_exists("dataContractsCount", $statistics) ? $statistics["dataContractsCount"] : '') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Data contracts running</strong></div>
                            <div class="col-md-2">{{ (array_key_exists("activeDataContractsCount", $statistics) ? $statistics["activeDataContractsCount"] : '') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
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
        <br><br>
        <div id="dataContractChart"></div>
        @columnchart('dataContractChart', 'dataContractChart')
        <br>
        <div id="nodeCountChart"></div>
        @columnchart('nodeCountChart', 'nodeCountChart')
        <br>
        <div id="taskResultsChart"></div>
        @columnchart('taskResultsChart', 'taskResultsChart')
        </div>
    </div>
@endsection
