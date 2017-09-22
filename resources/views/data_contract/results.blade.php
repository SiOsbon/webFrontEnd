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
                    <div class="panel-heading">Data contract results</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4"><strong>Title</strong></div>
                            <div class="col-md-4"><strong>Data</strong></div>
                        </div>
                        @for ($i=0; $i<count($resultTasks); $i++)
                            @foreach($resultTasks[$i]["data"] as $key => $value)
                                <div class="row">
                                    <div class="col-md-4">
                                        {{ $key }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ $value }}
                                    </div>
                                </div>
                            @endforeach
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
