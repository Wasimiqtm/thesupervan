
<div class="row">            
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Import Order Users</header>
            <div class="panel-body">
                <div class="position-center">                    
                    
                    <div class="form-group {{ $errors->has('file') ? 'has-error' : ''}}">
                        {!! Form::label('file', 'Import File', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}
                        <div class="col-lg-9">
                            {!! Form::file('file', ['class' => 'form-control', 'required', 'accept' => '.csv']) !!}
                            {!! $errors->first('file', '<p class="text-danger">:message</p>') !!}
                            <div class="text-danger with-errors"></div>
                        </div>
                    </div>
                    
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-info pull-right']) !!}
                    </div>
                </div>
                </div>
            </div>
        </section>

    </div>
</div>