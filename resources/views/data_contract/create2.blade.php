@extends('layouts.app_admin')

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
            <div class="col-m-12"><h2>Upload your data contract</h2></div>
        </div>
        <form method="POST" action="{{ route('data_contract_store') }}">
            {{ csrf_field() }}
        <div class="row">
            <div class="col-m-2">
                Data contract:
            </div>
            <div class="col-m-10">
                {{ Form::textarea('json_data_contract', '', ['size' => '92x15', 'class' => 'form-control']) }}
                @if ($errors->has('json_data_contract'))
                    <span class="help-block">
                        <strong>{{ $errors->first('json_data_contract') }}</strong>
                    </span>
                @endif
            </div>
            <p></p>
        </div>
            <div class="row">
                <div class="col-m-12">
                <button type="submit" class="btn btn-primary pull-right mt-15">
                    Add contract
                </button>
                </div>
            </div>
        </form>
    </div>
@endsection
