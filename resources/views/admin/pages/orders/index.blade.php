@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

@if ($lists->count() > 0)
    <div class="row">
        <div class="col-lg-12">
            <div class="">
                <div class="table-responsive">
                    <table class="table project-list-table table-nowrap align-middle table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('Customer Name')</th>
                                <th scope="col">@lang('Provider Name')</th>
                                <th scope="col">@lang('Order Status')</th>
                                <th scope="col">@lang('Answers')</th>
                                <th scope="col">@lang('Category')</th>
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show',$list->id) }}">
                                            {{ $list->id }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $list->customer->first_name ?? '' }}
                                    </td>
                                    <td>
                                        @if (!is_null($list->provider))
                                            {{ $list->provider->provider_name ?? '' }}
                                        @else
                                            {{ __("Not Have Yet") }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ __(str_replace("_"," ",$list->order_status)) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.answers',$list->id) }}">
                                            {{ $list->answers()->count() }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ ucfirst($list->category->name ?? '') }}
                                    </td>
                                    <td>
                                        {{ $list->created_at}}
                                    </td>
                                    <td style="display: inline-flex;">
                                        <a style="@if(\App::getLocale() == 'ar') margin-left: 5px; @else margin-right: 5px; @endif"
                                            class="btn btn-outline-secondary btn-sm edit"
                                            href="{{ route('admin.orders.show',$list->id) }}">
                                            <i class="bx bx-zoom-in"></i>
                                        </a>
                                        {!! action_table_delete(route('admin.orders.destroy',$list->id),$list->id) !!}                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $lists->links('admin.layouts.inc.paginator') }}
@else

    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <div class="row justify-content-center mt-5">
                    <div class="col-sm-4">
                        <div class="maintenance-img">
                            <img src="{{ url('assets/images/123.svg') }}" alt="" class="img-fluid mx-auto d-block">
                        </div>
                    </div>
                </div>
                <h4 class="mt-5">@lang("Let's get started")</h4>
                <p class="text-muted">@lang("Oops, We don't have data to display").</p>
            </div>
        </div>
    </div>


@endif

@endsection