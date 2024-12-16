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
                                <th scope="col" style="width: 100px">#</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Type')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        {{ $list->id ?? '' }}
                                    </td>
                                    <td>
                                        @if (!is_null($list->user))
                                            @if ($list->user->user_type == "customer")
                                                {{ $list->user->first_name ?? '' }} {{ $list->user->last_name ?? '' }}
                                            @else
                                                {{ $list->user->provider_name ?? '' }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        {{ __($list->message_type) ?? '' }}
                                    </td>
                                    <td>
                                        {!! $list->showStatus() !!}
                                    </td>
                                    <td>
                                        {{ $list->created_at}}
                                    </td>
                                    <td style="display: inline-flex;">
                                        <a style="@if(\App::getLocale() == 'ar') margin-left: 5px; @else margin-right: 5px; @endif" 
                                            class="btn btn-outline-success btn-sm edit" 
                                            href="{{ route('admin.contact-us.show',$list->id) }}">
                                            <i class="bx bxs-show"></i>
                                        </a>
                                        {!! action_table_delete(route('admin.contact-us.destroy',$list->id),$list->id) !!}
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
                <p class="text-muted">@lang("Oops, We don't have message").</p>
            </div>
        </div>
    </div>


@endif

@endsection