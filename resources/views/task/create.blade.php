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
                    <div class="panel-heading">Task create</div>

                    <div class="panel-body">
                        <form method="POST" action="{{ route('task_create') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                {{ Form::label('body', Lang::get('task.body_label'), ['class' => 'control-label col-md-2']) }}
                                <div class="col-md-10">
                                    {{ Form::textarea('body', null, ['size' => '92x15', 'class' => 'form-control']) }}
                                    @if ($errors->has('body'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('body') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary pull-right mt-15">
                                    @lang('task.submit_label')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
