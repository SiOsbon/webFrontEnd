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
            <p></p>
            <div>
                <div class="col-m-12">
                    <div class="col-m-12"><h2>Data contract results page</h2></div>

                </div>
            </div>
        <div class="row">
            <div class="col-m-2"><strong>Id</strong></div>
            <div class="col-m-6"><strong>Name</strong></div>
        </div>
        <div class="row">
            <div class="col-m-2">{{ $dataContractId }}</div>
            <div class="col-m-6"><a href="{{ route('data_contract_view', ["dataContractId" => $dataContractId]) }}"
                                    style="text-decoration: underline">{{ $contractName }}</a></div>
        </div>
            <p></p>

            @if (count($resultTasks) == 0)
                <div class="row">
                <div class="col-m-12">
                <h4>Data contract was not executed yet. Check if its started in data contract <a href="{{ route('data_contract_view', ["dataContractId" => $dataContractId]) }}"
                                                                                                 style="text-decoration: underline">details</a>.</h4>
                </div>
                </div>
            @else
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
                @endif
    </div>
@endsection
