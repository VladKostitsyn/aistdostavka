<!-- Id Field -->
<div class="form-group row col-md-4 col-sm-12">
    {!! Form::label('id', trans('lang.order_id'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
    <p>#{!! $order->id !!}</p>
        <hr class="w-50">
    </div>

    {!! Form::label('order_client', trans('lang.order_client'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
    <p>{!! $order->user->name !!}</p>
        <hr class="w-50">
  </div>

    {!! Form::label('order_client_phone', trans('lang.order_client_phone'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
    <p>{!! isset($order->user->phone)  ? $order->user->phone : ($order->user->custom_fields['phone']['view']) !!}</p>
        <hr class="w-50">
  </div>

    {!! Form::label('delivery_address', trans('lang.delivery_address'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
    <p>{!! $order->deliveryAddress ? $order->deliveryAddress->address : '---' !!}</p>
        <hr class="w-50">
  </div>

    {!! Form::label('order_date', trans('lang.order_date'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
    <p>{!! $order->created_at !!}</p>
        <hr class="w-50">
  </div>


</div>

<!-- Order Status Id Field -->
<div class="form-group row col-md-4 col-sm-12">
    {!! Form::label('order_status_id', trans('lang.order_status_status'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
    <p>{!! $order->orderStatus->status !!}</p>
        <hr class="w-50">
  </div>

    {!! Form::label('active', trans('lang.order_active'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
    @if($order->active)
      <p><span class='badge badge-success'> {{trans('lang.yes')}}</span></p>
      @else
      <p><span class='badge badge-danger'>{{trans('lang.order_canceled')}}</span></p>
      @endif
        <hr class="w-50">
  </div>

    {!! Form::label('payment_method', trans('lang.payment_method'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center ">
    <p>{!! isset($order->payment) ? $order->payment->method : ''  !!}</p>
        <hr class="w-50">
  </div>

    {!! Form::label('payment_status', trans('lang.payment_status'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
    <p>{!! isset($order->payment) ? $order->payment->status : trans('lang.order_not_paid')  !!}</p>
        <hr class="w-50">
  </div>
    {!! Form::label('order_updated_date', trans('lang.order_updated_at'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
        <p>{!! $order->updated_at !!}</p>
        <hr class="w-50">
    </div>

</div>

<!-- Id Field -->
<div class="form-group row col-md-4 col-sm-12">
    {!! Form::label('restaurant', trans('lang.restaurant'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
        @if(isset($order->foodOrders[0]))
            <p>{!! $order->foodOrders[0]->food->restaurant->name !!}</p>
        @endif
        <hr class="w-50">
    </div>

    {!! Form::label('restaurant_address', trans('lang.restaurant_address'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
        @if(isset($order->foodOrders[0]))
            <p>{!! $order->foodOrders[0]->food->restaurant->address !!}</p>
            <hr class="w-50">
        @endif
    </div>

    {!! Form::label('restaurant_phone', trans('lang.restaurant_phone'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
        @if(isset($order->foodOrders[0]))
            <p>{!! $order->foodOrders[0]->food->restaurant->phone !!}</p>
        @endif
        <hr class="w-50">
    </div>

    {!! Form::label('driver', trans('lang.driver'), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
        @if(isset($order->driver))
            <p>{!! $order->driver->name !!}</p>
        @else
            <p>{{trans('lang.order_driver_not_assigned')}}</p>
        @endif
        <hr class="w-50">

    </div>

    {!! Form::label('hint', trans("lang.order_hint"), ['class' => 'col-4 control-label']) !!}
    <div class="col-8 text-center">
        <p>{!! is_null($order->hint) ? '---': $order->hint!!}</p>
        <hr class="w-50">
    </div>

</div>

{{--<!-- Tax Field -->--}}
{{--<div class="form-group row col-md-6 col-sm-12">--}}
{{--  {!! Form::label('tax', 'Tax:', ['class' => 'col-4 control-label']) !!}--}}
{{--  <div class="col-8">--}}
{{--    <p>{!! $order->tax !!}</p>--}}
{{--  </div>--}}
{{--</div>--}}


