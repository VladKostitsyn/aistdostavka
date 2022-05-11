@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{trans('lang.order_plural')}}<small class="ml-3 mr-3">|</small><small>{{trans('lang.order_desc')}}</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> {{trans('lang.dashboard')}}</a></li>
          <li class="breadcrumb-item"><a href="{!! route('orders.index') !!}">{{trans('lang.order_plural')}}</a>
          </li>
          <li class="breadcrumb-item active">{{trans('lang.order')}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
  <div class="card">
    <div class="card-header d-print-none">
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item">
          <a class="nav-link" href="{!! route('orders.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.order_table')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.order')}}</a>
        </li>
        <div class="ml-auto d-inline-flex">
          <li class="nav-item">
            <a class="nav-link pt-1" id="printOrder" href="#"><i class="fa fa-print"></i> {{trans('lang.print')}}</a>
          </li>
        </div>
      </ul>
    </div>
    <div class="card-body ">
      <div class="row">
        @include('orders.show_fields')
      </div>
      {{--@include('food_orders.table')--}}
      <table class="w-100 mb-5  text-center">
        <thead class="text-bold">
        <tr>
          <td>
            <hr class="w-75">
            Продукты
            <hr class="w-75">
          </td>
          <td>
            <hr class="w-75">
            Добавки
            <hr class="w-75">
          </td>
          <td>
            <hr class="w-75">
            Цена
            <hr class="w-75">
          </td>
          <td>
            <hr class="w-75">
            Количество
            <hr class="w-75">
          </td>
        </tr>
        </thead>
        <tbody >
        @foreach($order->foodOrders as $food)
        <tr>

          <td>
            {!!  $food->food->name!!}
          <hr class="w-75">
          </td>
          <td>
            {!! empty(getArrayColumn($food->extras, 'name')) ? '---' : getArrayColumn($food->extras, 'name') !!}
          <hr class="w-75">
          </td>


          <td>
            {!! getPrice($order->foodOrders->price = getePriceWithExtras($food)) !!}
            <hr class="w-75">
          </td>
          <td>
            {!! $food->quantity  !!}
          <hr class="w-75">
          </td>
        </tr>

        @endforeach
        </tbody>

      </table>
      <div class="row">

        <div class="col col-lg-6 justify-content-center p-3" style=" border-left: 4px solid #d20f2c">
          <div class="table-responsive table-light text-center" >
            <h4 class="">{{trans('lang.order_Comment')}}</h4>
            <hr>
            <span class="">
              {{$order->order_comment}}
            </span>
          </div>
        </div>

        <div class="col-8 col-lg-6 pl-5">
        <div class="table-responsive table-light">
          <table class="table ">
            <tbody>
            <tr>
              <th class="text-right">{{trans('lang.order_subtotal')}}</th>
              <td>{!! getPrice($subtotal) !!}</td>
            </tr>
            <tr>
              <th class="text-right">{{trans('lang.order_delivery_fee')}}</th>
              <td>{!! getPrice($order['delivery_fee'])!!}</td>
            </tr>
            <tr>
              <th class="text-right">{{trans('lang.order_tax')}} ({!!$order->tax!!}%) </th>
              <td>{!! getPrice($taxAmount)!!}</td>
            </tr>

            <tr>
              <th class="text-right">{{trans('lang.order_total')}}</th>
              <td>{!!getPrice($total)!!}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>

      </div>
      <div class="clearfix"></div>
      <div class="row d-print-none">
        <!-- Back Field -->
        <div class="form-group col-12 text-right">
          <a href="{!! route('orders.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.back')}}</a>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script type="text/javascript">
    $("#printOrder").on("click",function () {
      window.print();
    });
  </script>
@endpush
