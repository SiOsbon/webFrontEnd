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
            <p>&nbsp;</p>
        {{ Form::open(['route' => 'node-register', 'method' => 'post', 'id' => 'register-form']) }}
            <div class="form-group row">
                <div class="col-l-3">
                    {{ Form::label('userEmail', "User email *") }}
                </div>
                <div class="col-l-5">
                    {{ Form::text('userEmail', old('userEmail'), ['class' => 'form-control']) }}
                    @if ($errors->has('userEmail'))
                        <div class="error-message">
                            <span>
                                <strong>{{ $errors->first('userEmail') }}</strong>
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-l-3">
                    {{ Form::label('ethAddress', "Ethereum address") }}
                </div>
                <div class="col-l-5">
                    {{ Form::text('ethAddress', old('ethAddress'), ['class' => 'form-control']) }}
                    @if ($errors->has('ethAddress'))
                        <div class="error-message">
                            <span>
                                <strong>{{ $errors->first('ethAddress') }}</strong>
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-l-3">
                    {{ Form::label('referalCode', "Referal code") }}
                </div>
                <div class="col-l-5">
                    {{ Form::text('referalCode', $referralCode, ['class' => 'form-control']) }}
                    @if ($errors->has('referalCode'))
                        <div class="error-message">
                            <span>
                                <strong>{{ $errors->first('referalCode') }}</strong>
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-l-3">

                </div>
                <div class="col-l-5">
                    <button type="submit">Register</button>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-l-3">

                </div>
                <div class="col-l-5">
                    * Mandatory fields
                </div>
            </div>
            <div class="form-group row">
                <div class="col-l-3">

                </div>
                <div class="col-l-5">
                    Node download <a href="{{ route("download") }}">page</a>
                </div>
            </div>
            {{ Form::close() }}
    </div>
@endsection