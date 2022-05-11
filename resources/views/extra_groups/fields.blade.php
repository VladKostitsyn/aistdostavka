@if($customFields)
    <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- Name Field -->
    <div class="form-group row ">
        {!! Form::label('name', trans("lang.extra_group_name"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.extra_group_name_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.extra_group_name_help") }}
            </div>
        </div>
    </div>

    <!-- is Required -->
    <div class="form-group row ">
        {!! Form::label('is_required', trans("lang.extra_group_is_required"),['class' => 'col-3 control-label text-right']) !!}
        <div class="checkbox icheck">
            <label class="col-9 ml-2 form-check-inline">
                {!! Form::hidden('is_required', 0) !!}
                {!! Form::checkbox('is_required', 1, null) !!}
            </label>
        </div>
    </div>

    <!-- is Single Selection -->
    <div class="form-group row ">
        {!! Form::label('is_singled', trans("lang.extra_group_is_singled"),['class' => 'col-3 control-label text-right']) !!}
        <div class="checkbox icheck">
            <label class="col-9 ml-2 form-check-inline">
                {!! Form::hidden('is_singled', 0) !!}
                {!! Form::checkbox('is_singled', 1, null) !!}
            </label>
        </div>
    </div>

</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
</div>
@if($customFields)
    <div class="clearfix"></div>
    <div class="col-12 custom-field-container">
        <h5 class="col-12 pb-4">{!! trans('lang.custom_field_plural') !!}</h5>
        {!! $customFields !!}
    </div>
@endif
<!-- Submit Field -->
<div class="form-group col-12 text-right">
    <button type="submit" class="btn btn-{{setting('theme_color')}}"><i
                class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.extra_group')}}</button>
    <a href="{!! route('extraGroups.index') !!}" class="btn btn-default"><i
                class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
