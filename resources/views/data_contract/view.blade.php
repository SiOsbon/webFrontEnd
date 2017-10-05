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
                            <div class="col-md-2"><strong>Id</strong></div>
                            <div class="col-md-4"><strong>Name</strong></div>
                            <div class="col-md-2"><strong>Data</strong></div>
                            <div class="col-md-2"><strong>Status</strong></div>
                            <div class="col-md-2"><strong>Operations</strong></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">{{ $dataContract['id'] }}</div>
                            <div class="col-md-4">{{ $dataContract['name'] }}</div>
                            <div class="col-md-2">
                                <a href="{{ route('data_contract_results', ['dataContractId' => $dataContract['id']]) }}">Results</a>
                            </div>
                            @if ($dataContract["status"] == \App\DataContract::STATUS_STARTED)
                                <div class="col-md-2">
                                    Started
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('data_contract_stop', ['dataContractId' => $dataContract['id']]) }}">
                                        Stop
                                    </a>
                                </div>
                            @else
                                <div class="col-md-2">
                                    Stopped
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('data_contract_start', ['dataContractId' => $dataContract['id']]) }}">
                                        Start
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <strong>Contract JSON:</strong>
                            </div>
                        </div>
                        <pre>
                            {{ json_encode($dataContract, JSON_PRETTY_PRINT) }}
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
