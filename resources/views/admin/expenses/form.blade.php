
<div class="row">            
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">{{ isset($submitButtonText) ? $submitButtonText : 'Add' }} Expense</header>
            <div class="panel-body">
                <div class="position-center">                                                                                                                                        
                    
                    <!--<div class="form-group {{ $errors->has('type_id') ? 'has-error' : ''}}">-->
                    <!--    {!! Form::label('type_id', 'Expense Type', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}-->
                    <!--    <div class="col-lg-9">-->
                    <!--        {!! Form::select('type_id', $expenseTypes, null, ['class' => 'form-control select2','placeholder' => 'Expense Type','required' => 'required']) !!}-->
                    <!--        {!! $errors->first('type_id', '<p class="help-block">:message</p>') !!}-->
                    <!--        <div class="help-block with-errors"></div>-->
                    <!--    </div>-->
                    <!--</div> -->
                    
                    <div class="form-group {{ $errors->has('date') ? 'has-error' : ''}}">
                        {!! Form::label('date', 'Date', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}
                        <div class="col-lg-9">
                            {!! Form::text('date', null, ['class' => 'form-control datepicker','required' => 'required']) !!}
                            {!! $errors->first('date', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div> 
                    
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name', 'Name', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}
                        <div class="col-lg-9">
                            {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Name','required' => 'required']) !!}
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>                                                                                                                      
                    
                    <div class="form-group {{ $errors->has('amount') ? 'has-error' : ''}}">
                        {!! Form::label('amount', 'Amount', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}
                        <div class="col-lg-9">
                            {!! Form::number('amount', null, ['class' => 'form-control','placeholder' => 'Amount','required' => 'required', 'min' => '0']) !!}
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>                                                                                                                      
                    
                <!--    <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">-->
                <!--        {!! Form::label('image', 'Image', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}                        -->
                <!--    <div class="col-md-9">-->
                <!--        <div class="fileupload fileupload-new" data-provides="fileupload">-->
                <!--            <div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px;">-->
                <!--                <img src="{{ checkImage('expenses/'. @$expense->image) }}" alt="" />-->
                <!--            </div>-->
                <!--            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>-->
                <!--            <div>-->
                <!--                <span class="btn btn-white btn-file">-->
                <!--                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>-->
                <!--                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>-->
                <!--                <input type="file" class="default" name="image" accept="image/*" />-->
                <!--                </span>-->
                <!--                <a href="#" class="btn btn-info fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>-->
                <!--            </div>-->
                <!--            {!! $errors->first('image', '<p class="help-block">:message</p>') !!}-->
                <!--            <div class="help-block with-errors"></div>-->
                <!--        </div>                        -->
                <!--    </div>-->
                <!--</div>-->

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


@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $(".datepicker").datepicker();
    });
</script>
@endsection