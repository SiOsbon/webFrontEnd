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
            <div class="panel-body">
                <form method="POST" action="{{ route('data_contract_store') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('json_data_contract') ? ' has-error' : '' }}">
                        <div class="col-md-2">
                            Data contract:
                        </div>
                        <div class="col-md-10">
                            {{ Form::textarea('json_data_contract', '', ['size' => '92x15', 'class' => 'form-control']) }}
                            @if ($errors->has('json_data_contract'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('json_data_contract') }}</strong>
                                </span>
                            @endif
                        </div>
                        <br><br>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary pull-right mt-15">
                            Add contract
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
