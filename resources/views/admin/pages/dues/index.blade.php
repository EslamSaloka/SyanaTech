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
                                <th scope="col">@lang('Provider')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Dues Cost')</th>
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td><img src="{{ display_image_by_model($list->provider,'avatar') }}" alt="" class="avatar-sm"></td>
                                    <td>
                                        {{ $list->provider->provider_name ?? '' }}
                                    </td>
                                    <td>
                                        @lang('Completed Due')
                                    </td>
                                    <td>
                                        {{ $list->total }} {{ __("SAR") }}
                                    </td>
                                    <td>
                                        {{ $list->created_at}}
                                    </td>
                                    <td {{--style="display: inline-flex;" --}}>
                                        <a style="@if(\App::getLocale() == 'ar') margin-left: 5px; @else margin-right: 5px; @endif"
                                            class="btn btn-outline-secondary btn-sm edit"
                                            href="{{ route('admin.dues.show',$list->id) }}">
                                            <i class="bx bx-zoom-in"></i>
                                        </a>
                                        {{-- @if ($list->accept == 0 && $list->reject == 0)
                                            <a style="@if(\App::getLocale() == 'ar') margin-left: 5px; @else margin-right: 5px; @endif"
                                                class="btn btn-outline-secondary btn-sm edit"
                                                href="{{ route('admin.dues.accept',$list->id) }}">
                                                <i class="bx bx-check-circle"></i>
                                            </a>
                                            <a style="@if(\App::getLocale() == 'ar') margin-left: 5px; @else margin-right: 5px; @endif"
                                                class="btn btn-outline-secondary btn-sm edit"
                                                href="{{ route('admin.dues.reject',$list->id) }}">
                                                <i class="bx bx-x-circle"></i>
                                            </a>
                                        @endif --}}
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
