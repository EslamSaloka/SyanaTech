@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

<div class="row">
    <div class="col-lg-8">
        <h6>
            @lang('Customer Information')
        </h6>
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">@lang('name')</th>
                            <th scope="col">@lang('email')</th>
                            <th scope="col">@lang('phone')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ $order->customer->first_name ?? '----' }}
                            </td>
                            <td>
                                {{ $order->customer->email ?? '----' }}
                            </td>
                            <td>
                                {{ $order->customer->phone ?? '----' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <h6>
            @lang('Address Information')
        </h6>
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">@lang('address name')</th>
                            <th scope="col">@lang('location name')</th>
                            <th scope="col">@lang('lat name')</th>
                            <th scope="col">@lang('lng name')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ $order->address_name }}
                            </td>
                            <td>
                                {{ $order->location_name }}
                            </td>
                            <td>
                                {{ $order->lat }}
                            </td>
                            <td>
                                {{ $order->lng }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <h6>
            @lang('Customer Car Information')
        </h6>
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Model')</th>
                            <th scope="col">@lang('Factory')</th>
                            <th scope="col">@lang('Color')</th>
                            <th scope="col">@lang('manufacturer')</th>
                            <th scope="col">@lang('Year')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ $order->car->vdsData->name ?? '----' }}
                            </td>
                            <td>
                                {{ $order->carCountryFactory->name ?? '----' }}
                            </td>
                            <td>
                                {{ $order->car['color']['name'] ?? '----' }}
                            </td>
                            <td>
                                {{ $order->car->manufacturerData->name ?? '----' }}
                            </td>
                            <td>
                                {{ $order->car["modelYear"] ?? '----' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <h6>
            @lang('Provider Information')
        </h6>
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">@lang('name')</th>
                            <th scope="col">@lang('email')</th>
                            <th scope="col">@lang('phone')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ $order->provider->provider_name ?? '----' }}
                            </td>
                            <td>
                                {{ $order->provider->email ?? '----' }}
                            </td>
                            <td>
                                {{ $order->provider->phone ?? '----' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <h6>
            @lang('Order Items')
        </h6>
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Name')</th>
                            <th scope="col">@lang('Price')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>
                                    {{ $item->name ?? '----' }}
                                </td>
                                <td>
                                    {{ $item->price ?? '----' }} @lang('SAR')
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <h6>
            @lang('Order Images')
        </h6>
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <tbody>
                        @foreach ($order->images as $image)
                            <tr>
                                <td>
                                    <img src="{{ display_image_by_model($image,'image') }}" alt="">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">

        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                @lang('Sub Total')
                            </td>
                            <td>
                                {!! $order->sub_total !!} @lang('SAR')
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Vat')
                            </td>
                            <td>
                                {!! $order->vat !!} @lang('SAR')
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Total')
                            </td>
                            <td>
                                {!! $order->total !!} @lang('SAR')
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Status')
                            </td>
                            <td>
                                {{ __(str_replace("_"," ",$order->order_status)) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Created At')
                            </td>
                            <td>
                                {{ $order->created_at }}
                            </td>
                        </tr>
                        @if (!is_null($order->process_at))
                            <tr>
                                <td>
                                    @lang('Process At')
                                </td>
                                <td>
                                    {{ $order->process_at }}
                                </td>
                            </tr>
                        @endif
                        @if ($order->order_status == "done")
                            <tr>
                                <td>
                                    @lang('Dues')
                                </td>
                                <td>
                                    <?php
                                        $checkDues = \App\Models\Dues\Item::where("order_id",$order->id)->whereHas("Dues",function($q){
                                            return $q->where("dues.accept",1);
                                        })->first();
                                    ?>
                                    @if(!is_null($checkDues))
                                        <span class="make_pad badge bg-success">{{ __("Dues paid") }}</span>
                                    @else
                                        <span class="make_pad badge bg-danger">{{ __("Dues unpaid") }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>
                                @lang('Category')
                            </td>
                            <td>
                                {{ $order->category->name ?? '----' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('carCountryFactory')
                            </td>
                            <td>
                                {{ $order->carCountryFactory->name ?? '----' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('region')
                            </td>
                            <td>
                                {{ $order->region->name ?? '----' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('city')
                            </td>
                            <td>
                                {{ $order->city->name ?? '----' }}
                            </td>
                        </tr>
                        @if($order->order_status == 'cancel')
                        <tr>
                            <td>
                                @lang('Refusals_reason')
                            </td>
                            <td>
                                {{ $order->refusals->name ?? '----' }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection
