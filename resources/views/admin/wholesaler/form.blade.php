<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Shopkeeper</header>
            <div class="panel-body">
                <div class="position-center" style="width:65%;">

                    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
                        {!! Form::label('first_name', 'First Name', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::text('first_name', null, ['class' => 'form-control','placeholder' => 'First Name','required' => 'required']) !!}
                            {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
                        {!! Form::label('last_name', 'Last Name', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::text('last_name', null, ['class' => 'form-control','placeholder' => 'Last Name','required' => 'required']) !!}
                            {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                        {!! Form::label('email', 'Email', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            @if(@$user)
                            {!! Form::email('email', null, ['class' => 'form-control','placeholder' => 'Email','readonly']) !!}
                            @else
                            {!! Form::email('email', null, ['class' => 'form-control','placeholder' => 'Email','required' => 'required']) !!}
                            @endif
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('shop_name') ? 'has-error' : ''}}">
                        {!! Form::label('shop_name', 'Shop Name', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::text('shop_name', null, ['class' => 'form-control','placeholder' => 'Shop Name']) !!}
                            {!! $errors->first('shop_name', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="hidden form-group {{ $errors->has('vat_number') ? 'has-error' : ''}}">
                        {!! Form::label('vat_number', 'Vat #', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::text('vat_number', null, ['class' => 'form-control','placeholder' => 'Vat #']) !!}
                            {!! $errors->first('vat_number', '<p class="help-block">:message</p>') !!}
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
                    <div class="hidden form-group  {{ $errors->has('quantity_1') ? 'has-error' : ''}}">
                        {!! Form::label('quantity_1', 'Quantity & Cost (%) 1', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                {!! Form::number('quantity_1', null, ['class' => 'form-control','placeholder' => 'Quantity','min' => '0']) !!}
                                {!! $errors->first('quantity_1', '<p class="help-block">:message</p>') !!}
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                {!! Form::number('percentage_1', null, ['class' => 'form-control','placeholder' => 'Percentage','min' => '0']) !!}
                                {!! $errors->first('percentage_1', '<p class="help-block">:message</p>') !!}
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden form-group  {{ $errors->has('quantity_2') ? 'has-error' : ''}}">
                        {!! Form::label('quantity_2', 'Quantity & Cost (%) 2', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                {!! Form::number('quantity_2', null, ['class' => 'form-control','placeholder' => 'Quantity','min' => '0']) !!}
                                {!! $errors->first('quantity_2', '<p class="help-block">:message</p>') !!}
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                {!! Form::number('percentage_2', null, ['class' => 'form-control','placeholder' => 'Percentage','min' => '0']) !!}
                                {!! $errors->first('percentage_2', '<p class="help-block">:message</p>') !!}
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden form-group  {{ $errors->has('quantity_3') ? 'has-error' : ''}}">
                        {!! Form::label('quantity_3', 'Quantity & Cost (%) 3', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                {!! Form::number('quantity_3', null, ['class' => 'form-control','placeholder' => 'Quantity','min' => '0']) !!}
                                {!! $errors->first('quantity_3', '<p class="help-block">:message</p>') !!}
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                {!! Form::number('percentage_3', null, ['class' => 'form-control','placeholder' => 'Percentage','min' => '0']) !!}
                                {!! $errors->first('percentage_3', '<p class="help-block">:message</p>') !!}
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden form-group {{ $errors->has('mark_up') ? 'has-error' : ''}}">
                        {!! Form::label('mark_up', 'Markup', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::number('mark_up', null, ['class' => 'form-control','placeholder' => 'Markup','min' => '0']) !!}
                            {!! $errors->first('mark_up', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('is_active') ? 'has-error' : ''}}">
                        {!! Form::label('is_active', 'Status', ['class' => 'col-lg-3 col-sm-3 control-label']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::select('is_active', ['yes'=>'Active','no'=>'Inactive'],null, ['class' => 'form-control']) !!}
                            {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
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

                    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                        {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'col-lg-3 col-sm-3 control-label required-input']) !!}
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            {!! Form::password('password_confirmation', ['class' => 'form-control','placeholder' => 'Confirm Password','required' => 'required','data-match'=>'#password']) !!}
                            {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
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