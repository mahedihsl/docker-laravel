<div class="form-group {{ $errors->has('amount') ? 'has-error' : ''}}">
    {!! Form::label('amount', 'Amount', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('amount', null, ['class' => 'form-control','required' => 'required']) !!}
        {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('volume') ? 'has-error' : ''}}">
    {!! Form::label('volume', 'Volume', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('volume', null, ['class' => 'form-control','required' => 'required']) !!}
        {!! $errors->first('volume', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('recharged_at') ? 'has-error' : ''}}">
    {!! Form::label('recharged_at', 'Recharged At', ['class' => 'col-md-4 control-label','required' => 'required']) !!}
    <div class="col-md-6">
        {!! Form::date('recharged_at', null, ['class' => 'form-control']) !!}
        {!! $errors->first('recharged_at', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('validity') ? 'has-error' : ''}}">
    {!! Form::label('validity', 'Validity', ['class' => 'col-md-4 control-label',]) !!}
    <div class="col-md-6">
        {!! Form::date('validity', null, ['class' => 'form-control','required' => 'required']) !!}

        {!! $errors->first('validity', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
