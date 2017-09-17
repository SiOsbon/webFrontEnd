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
                            <div class="col-md-3"><strong>Nodes registered</strong></div>
                            <div class="col-md-2">{{ $statistics["registeredNodesCount"] }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><strong>Total data contracts</strong></div>
                            <div class="col-md-2">{{ $statistics["dataContractsCount"] }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><strong>Data contracts running</strong></div>
                            <div class="col-md-2">{{ $statistics["activeDataContractsCount"] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
            <div id="dataContractChart"></div><br>
            @columnchart('dataContractChart', 'dataContractChart')
            <div id="tasksChart"></div>
            @columnchart('tasksChart', 'tasksChart')
                </div>
            </div>
    </div>
@endsection
