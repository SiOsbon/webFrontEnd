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
        @php
            $pageCnt = ceil($allCount/$count);
        @endphp
        <div class="row">
            <div class="col-m-12"><h2>Data contract <strong>'{{ $contractName }}'</strong> results</h2></div>
        </div>
        <div class="row">
            @for ($i=0; $i<count($resultTasks); $i++)
                <div class="row">
                    <div class="col-m-12">
                         Task:
                    </div>
                </div>
                <div class="row">
                    <div class="col-m-4"><strong>Title</strong></div>
                    <div class="col-m-4"><strong>Data</strong></div>
                </div>
                @foreach($resultTasks[$i]["data"] as $key => $value)
                    <div class="row">
                        <div class="col-m-4">
                            {{ $key }}
                        </div>
                        <div class="col-m-4">
                            {{ $value }}
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-m-8">
                        &nbsp;
                    </div>
                </div>
            @endfor
            @if ($allCount > count($count))
                <div class="row">
                    <div class="col-m-12">
                    @for($i=0; $i < $pageCnt; $i++)
                        @if ($i + 1 == $pageCnt)
                                @php
                                    $sep = "";
                                @endphp
                            @else
                                @php
                                    $sep = ", ";
                                @endphp
                        @endif
                        @if ($i == $page)
                            <strong>[{{($i + 1)}}]</strong>{{ $sep }}
                        @else
                            <a href="{{ route('data_contract_results', ['dataContractId' => $dataContractId,
                                'page' => $i]) }}">{{($i + 1)}}</a>{{ $sep }}
                        @endif
                    @endfor
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
