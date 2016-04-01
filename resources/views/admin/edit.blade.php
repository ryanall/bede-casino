@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if(Session::has('message'))
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">Edit casino</div>
            <div class="panel-body">
                @if (!empty($casino))
                    {{ Form::model($casino, array('route' => array('manage.update', $casino->id), 'method' => 'PUT', 'class'=>'form')) }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::label('name', 'Name') }}
                            {{ Form::text('name', null, array('class' => 'form-control')) }}
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('web_address') ? ' has-error' : '' }}">
                            {{ Form::label('web_address', 'Web Address') }}
                            {{ Form::text('web_address', null, array('class' => 'form-control')) }}
                            @if ($errors->has('web_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('web_address') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                              <div class="col-xs-6">
                                <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
                                    {{ Form::label('longitude', 'Longitude') }}
                                    {{ Form::text('longitude', null, array('class' => 'form-control')) }}
                                    @if ($errors->has('longitude'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('longitude') }}</strong>
                                        </span>
                                    @endif
                                </div>
                              </div>
                              <div class="col-xs-6">
                                <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
                                    {{ Form::label('latitude', 'Latitude') }}
                                    {{ Form::text('latitude', null, array('class' => 'form-control')) }}
                                    @if ($errors->has('latitude'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('latitude') }}</strong>
                                        </span>
                                    @endif
                                </div>
                              </div>
                        </div> 
                        <div class="form-group{{ $errors->has('opening_times') ? ' has-error' : '' }}">
                            {{ Form::label('opening_times', 'Opening Times') }}
                            {{ Form::textarea('opening_times', null, array('class' => 'form-control')) }}
                            @if ($errors->has('opening_times'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('opening_times') }}</strong>
                                </span>
                            @endif
                        </div>
                        {{ Form::submit('Update', array('class' => 'btn btn-success')) }} <a href="/manage" class="btn btn-info">Go back to results?</a>
                    {{ Form::close() }}
                @else
                    <div class="alert alert-dismissible alert-danger no-margin">
                        This resource doesn't exist
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
