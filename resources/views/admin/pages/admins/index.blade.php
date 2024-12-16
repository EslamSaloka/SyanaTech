@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')


<div style=" margin-bottom: 14px; position: relative; text-align: left; ">
    <a type="button" class="btn btn-primary"  href="{{route('admin.admins.create')}}">@lang('Create new admin')</a>
    <button
        class="btn btn-primary my-action"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasWithBothOptionsFilter"
        data-title="@lang('Filter')"
        aria-controls="offcanvasWithBothOptionsFilter"><i class="bx bx-filter-alt"></i></button>
</div>

@if ($lists->count() > 0)
    <div class="row">
        <div class="col-lg-12">
            <div class="">
                <div class="table-responsive">
                    <table class="table project-list-table table-nowrap align-middle table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td><img src="{{ display_image_by_model($list,'avatar',"first_name") }}" alt="" class="avatar-sm"></td>
                                    <td>
                                        <a href="{{ route('admin.admins.edit',$list->id) }}">
                                            {{ $list->first_name ?? '' }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $list->created_at}}
                                    </td>
                                    <td style="display: inline-flex;">
                                        <a style="@if(\App::getLocale() == 'ar') margin-left: 5px; @else margin-right: 5px; @endif"
                                            class="btn btn-outline-secondary btn-sm edit"
                                            href="{{ route('admin.admins.edit',$list->id) }}">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                        @if($list->super_admin == 0)
                                            {!! action_table_delete(route('admin.admins.destroy',$list->id),$list->id) !!}                                        
                                        @endif
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


<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptionsFilter" aria-labelledby="offcanvasWithBothOptionsLabel">
    <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">@lang('Filter')</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('admin.admins.index') }}" method="get" enctype="multipart/form-data">

            <div class="mb-3 row">
                <div class="col-md-12">
                    <input class="form-control" value="{{ request('name','') }}" name="name" type="name" placeholder="@lang('Search by name or email')" id="example-text-input">
                </div>
            </div>
            <div class="row" style=" margin-top: 20px; ">
                <div style="text-align: right">
                    <a href="{{ route('admin.admins.index') }}" style=" float: left; " class="btn btn-primary w-md">
                        @lang('Reset')
                    </a>
                    <button type="submit" class="btn btn-primary w-md">@lang('Submit')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $('.my-action').click(function(){
            $('#offcanvasWithBothOptionsLabel').html($(this).data('title'));
        });
    </script>
@endpush