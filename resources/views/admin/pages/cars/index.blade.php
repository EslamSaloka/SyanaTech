@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
    @includeIf('admin.layouts.inc.breadcrumb')

    <!--<div style=" margin-bottom: 14px; position: relative; text-align: @if(\App::getLocale() == 'ar') left @else right @endif; ">-->
    <!--    <a type="button" class="btn btn-primary"  href="{{route('admin.cars.create')}}">@lang('Create new car')</a>-->
    <!--</div>-->

    @if ($lists->count() > 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <div class="table-responsive">
                        <table class="table project-list-table table-nowrap align-middle table-borderless">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Customer')</th>
                                <th scope="col">@lang('Vin')</th>
                                <th scope="col">@lang('manufacturer')</th>
                                <th scope="col">@lang('Model')</th>
                                <th scope="col">@lang('Color')</th>
                                <th scope="col">@lang('Car Factory')</th>
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        {{ $list->user->first_name ?? '' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.cars.edit',$list->id) }}">
                                            {{ $list->vin ?? '----' }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $list->manufacturerData->name ?? '----' }}
                                    </td>
                                    <td>
                                        {{ $list->vdsData->name ?? '----' }}
                                    </td>
                                    <td>
                                        {{ $list->color->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $list->carCountryFactory->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $list->created_at}}
                                    </td>
                                    <td style="display: inline-flex;">
                                        {!! action_table_delete(route('admin.cars.destroy',$list->id),$list->id) !!}
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
