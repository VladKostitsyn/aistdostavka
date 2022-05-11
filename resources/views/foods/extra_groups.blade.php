@foreach ($extraGroupsSelected as $extraGroup)
    <div class="row" id="extra_group_{{ $extraGroup->id }}">
        <div class="col-3 text-right">
            {!! Form::label('extra_group_' . $extraGroup->id, $extraGroup->name, ['class' => 'control-label']) !!}
            <i class="fa fa-chevron-up" onclick="$('#extra_group_{{ $extraGroup->id }}_extras').toggle(); $(this).toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');"></i>
        </div>
        <div id="extra_group_{{ $extraGroup->id }}_extras" class="col-9">
            @foreach ($extraGroup->extras as $extra)
                <div class="row">
                    <div class="col-7">
                        {{ $extra->name }}
                    </div>
                    <div class="col-3">
                        {{ $extra->price }}
                    </div>
                    <div class="col-2">
                        <div class="checkbox icheck">
                            <label class="col-9 ml-2 form-check-inline">
                                {!! Form::checkbox('extras[]', $extra->id, in_array($extra->id, $extrasSelected)) !!}
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach