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
            <div class="col-m-12"><h2>Data contract details</h2></div>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-m-2"><strong>Id</strong></div>
                <div class="col-m-4"><strong>Name</strong></div>
                <div class="col-m-2"><strong>Data</strong></div>
                <div class="col-m-2"><strong>Status</strong></div>
                <div class="col-m-2"><strong>Operations</strong></div>
            </div>
            <div class="row">
                <div class="col-m-2">{{ $dataContract['id'] }}</div>
                <div class="col-m-4">{{ $dataContract['name'] }}</div>
                <div class="col-m-2">
                    <a href="{{ route('data_contract_results', ['dataContractId' => $dataContract['id']]) }}">Results</a>
                </div>
                @if ($dataContract["status"] == \App\DataContract::STATUS_STARTED)
                    <div class="col-m-2">
                        Started
                    </div>
                    <div class="col-m-2">
                        <a href="{{ route('data_contract_stop', ['dataContractId' => $dataContract['id']]) }}">
                            Stop
                        </a>
                    </div>
                @else
                    <div class="col-m-2">
                        Stopped
                    </div>
                    <div class="col-m-2">
                        <a href="{{ route('data_contract_start', ['dataContractId' => $dataContract['id']]) }}">
                            Start
                        </a>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-m-12">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col-m-12">
                    <strong>Contract JSON:</strong>
                    <p></p>
                    <pre>
                        {{ json_encode($dataContract, JSON_PRETTY_PRINT) }}
                    </pre>
                </div>
            </div>
        </div>
    </div>
@endsection
