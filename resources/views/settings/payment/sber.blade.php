@extends('layouts.settings.default')
@push('css_lib')
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
    <!-- select2 -->
    <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    {{--dropzone--}}
    <link rel="stylesheet" href="{{asset('plugins/dropzone/bootstrap.min.css')}}">
@endpush
@section('settings_title',trans('lang.user_table'))
@section('settings_content')
    @include('flash::message')
    @include('adminlte-templates::common.errors')
    <div class="clearfix"></div>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                <li class="nav-item">
                    <a class="nav-link" href="{!! url('settings/payment/payment') !!}"><i class="fa fa-money mr-2"></i>{{trans('lang.app_setting_payment')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{!! url('settings/payment/paypal') !!}"><i class="fa fa-envelope mr-2"></i>{{trans('lang.app_setting_paypal')}}@if(setting('enable_paypal', false))<span class="badge ml-2 badge-success">{{trans('lang.active')}}</span>@endif</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{!! url('settings/payment/stripe') !!}"><i class="fa fa-envelope-o mr-2"></i>{{trans('lang.app_setting_stripe')}}@if(setting('enable_stripe',false))<span class="badge ml-2 badge-success">{{trans('lang.active')}}</span>@endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{!! url('settings/payment/razorpay') !!}"><i class="fa fa-envelope-o mr-2"></i>{{trans('lang.app_setting_razorpay')}}@if(setting('enable_razorpay',false))<span class="badge ml-2 badge-success">{{trans('lang.active')}}</span>@endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{!! url('settings/payment/sber') !!}"><i class="fa fa-envelope-o mr-2"></i>{{trans('lang.app_setting_sber')}}@if(setting('enable_sber',false))<span class="badge ml-2 badge-success">{{trans('lang.active')}}</span>@endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{!! url('settings/payment/modulbank') !!}"><i class="fa fa-envelope-o mr-2"></i>{{trans('lang.app_setting_modulbank')}}@if(setting('enable_modulbank',false))<span class="badge ml-2 badge-success">{{trans('lang.active')}}</span>@endif
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            {!! Form::open(['url' => ['settings/update'], 'method' => 'patch']) !!}
            <div class="row">
                <div style="flex: 70%;max-width: 70%;padding: 0 4px;" class="column">
                    <div class="form-group row col-12">
                        {!! Form::label('enable_sber', trans('lang.app_setting_enable_sber'),['class' => 'col-3 control-label text-right']) !!}
                        <div class="checkbox icheck">
                            <label class="w-100 ml-2 form-check-inline">
                                {!! Form::hidden('enable_sber', null) !!}
                                {!! Form::checkbox('enable_sber', 1, setting('enable_sber', false)) !!}
                                <span class="ml-2">{!! trans('lang.app_setting_enable_sber_help') !!}</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row col-12">
                        {!! Form::label('enable_sber_production', trans('lang.app_setting_enable_sber_production'),['class' => 'col-3 control-label text-right']) !!}
                        <div class="checkbox icheck">
                            <label class="w-100 ml-2 form-check-inline">
                                {!! Form::hidden('enable_sber_production', null) !!}
                                {!! Form::checkbox('enable_sber_production', 1, setting('enable_sber_production', false)) !!}
                                <span class="ml-2">{!! trans('lang.app_setting_enable_sber_production_help') !!}</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row col-12">
                        {!! Form::label('sber_login', trans('lang.app_setting_sber_login'), ['class' => 'col-3 control-label text-right']) !!}
                        <div class="col-9">
                            {!! Form::text('sber_login', setting('sber_login'),  ['class' => 'form-control','placeholder'=>  trans('lang.app_setting_sber_login_placeholder')]) !!}
                            <div class="form-text text-muted">
                                {!! trans('lang.app_setting_sber_login_help') !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-12">
                        {!! Form::label('sber_pass', trans('lang.app_setting_sber_pass'), ['class' => 'col-3 control-label text-right']) !!}
                        <div class="col-9">
                            {!! Form::password('sber_pass', ['class' => 'form-control','placeholder'=>  setting('sber_pass') != '' ? '••••••••••••' : trans('lang.app_setting_sber_pass_placeholder')]) !!}
                            <div class="form-text text-muted">
                                {!! trans('lang.app_setting_sber_pass_help') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Field -->
                <div class="form-group mt-4 col-12 text-right">
                    <button type="submit" class="btn btn-{{setting('theme_color')}}"><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.app_setting_payment')}}</button>
                    <a href="{!! route('users.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
                </div>

            </div>
            {!! Form::close() !!}
            <div class="clearfix"></div>
        </div>
    </div>
    @include('layouts.media_modal',['collection'=>null])
@endsection
@push('scripts_lib')
    <!-- iCheck -->
    <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
    <!-- select2 -->
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    {{--dropzone--}}
    <script src="{{asset('plugins/dropzone/dropzone.js')}}"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        var dropzoneFields = [];
    </script>
@endpush
