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
                            <div class="col-md-4"><strong>Name</strong></div>
                        </div>
                        @foreach($dataContracts as $dataContract)
                            <div class="row">
                                <div class="col-md-4">
                                    {{ $dataContract['name'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
