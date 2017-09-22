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
                    <div class="panel-heading">All data contracts</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2"><strong>Id</strong></div>
                            <div class="col-md-4"><strong>Name</strong></div>
                            <div class="col-md-2"><strong>Data</strong></div>
                            <div class="col-md-2"><strong>Status</strong></div>
                            <div class="col-md-2"><strong>Operations</strong></div>
                        </div>
                        @foreach($dataContracts as $dataContract)
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="{{ route('data_contract_view', ['dataContractId' => $dataContract['id']]) }}">
                                        {{ $dataContract['id'] }}
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    {{ $dataContract['name'] }}
                                </div>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
