<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">{{ request()->type }}</header>
            <div class="panel-body">
                <div class="position-center" style="width:65%;">
                    
                    <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                        {!! Form::label('type', 'Customer Type', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::select('type', ['shopkeeper' => 'Shopkeeper', 'wholesaler' => 'Wholesaler'], @request()->type, ['class' => 'form-control','placeholder' => 'Customer Type','required' => 'required']) !!}
                            {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('customer_id') ? 'has-error' : ''}}">
                        {!! Form::label('customer_id', 'Customer ID', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::text('customer_id', null, ['class' => 'form-control','placeholder' => 'Customer ID']) !!}
                            {!! $errors->first('customer_id', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name', 'Name', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Name','required' => 'required']) !!}
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
                        {!! Form::label('company_name', 'Business Name', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::text('company_name', null, ['class' => 'form-control','placeholder' => 'Business Name']) !!}
                            {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                        {!! Form::label('email', 'Email', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::email('email', null, ['class' => 'form-control','placeholder' => 'Email','required' => 'required']) !!}
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                        {!! Form::label('phone', 'Contact #', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::text('phone', null, ['class' => 'form-control','placeholder' => 'Contact #']) !!}
                            {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    
                    {{-- <div class="form-group {{ $errors->has('shop_name') ? 'has-error' : ''}}">
                        {!! Form::label('shop_name', 'Shop Name', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::text('shop_name', null, ['class' => 'form-control','placeholder' => 'Shop Name']) !!}
                            {!! $errors->first('shop_name', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div> --}}
                    
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
                        {!! Form::label('address', 'Address', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::text('address', null, ['class' => 'form-control','placeholder' => 'Address']) !!}
                            {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    {{-- <div class="form-group {{ $errors->has('city') ? 'has-error' : ''}}">
                        {!! Form::label('city', 'City', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::text('city', null, ['class' => 'form-control','placeholder' => 'City']) !!}
                            {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('postal_code') ? 'has-error' : ''}}">
                        {!! Form::label('postal_code', 'Postal Code', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::text('postal_code', null, ['class' => 'form-control','placeholder' => 'Postal Code']) !!}
                            {!! $errors->first('postal_code', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div> --}}

                    <div class="form-group {{ $errors->has('notes') ? 'has-error' : ''}}">
                        {!! Form::label('notes', 'Notes', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::textarea('notes', null, ['class' => 'form-control','placeholder' => 'Notes', 'rows' => 2]) !!}
                            {!! $errors->first('notes', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    {{-- <div class="form-group {{ $errors->has('is_active') ? 'has-error' : ''}}">
                        {!! Form::label('is_active', 'Status', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::select('is_active', ['yes'=>'Active','no'=>'Inactive'],null, ['class' => 'form-control']) !!}
                            {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div> --}}
                    @if(@$user)
                    @else
                    <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                        {!! Form::label('password', 'Password', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::password('password', ['class' => 'form-control','placeholder' => 'Password','required' => 'required','data-minlength' => 6]) !!}
                            {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    @endif

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
        
    });
</script>
@endsection