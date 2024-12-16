@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

<!--<div style=" margin-bottom: 14px; position: relative; text-align: @if(\App::getLocale() == 'ar') left @else right @endif; ">-->
<!--    <a type="button" class="btn btn-primary"  href="{{route('admin.providers.create')}}">@lang('Create new provider')</a>-->
<!--</div>-->

<div style=" margin-bottom: 14px; position: relative; text-align: left; ">
    <a class="btn btn-outline-primary open-modal">
        @lang('Change Vat & Commission')
    </a>
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
                                <th scope="col">@lang('Image')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Rates')</th>
                                <th scope="col">@lang('Dues Cost')</th>
                                <th scope="col">@lang('Dues Order Count')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Vat')</th>
                                <th scope="col">@lang('Commission')</th>
                                <th scope="col">@lang('Created At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="ids" value='{!! $list->providerIndex() !!}'>
                                    </td>
                                    <td><img src="{{ display_image_by_model($list,'avatar',"provider_name") }}" alt="" class="avatar-sm"></td>
                                    <td>
                                        <a href="{{ route('admin.providers.edit',$list->id) }}">
                                            {{ $list->provider_name ?? '' }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.providers.rates',$list->id) }}">
                                            {{ $list->rates}}
                                        </a>
                                    </td>
                                    @php
                                        $p = displayDuesForProvider($list)
                                    @endphp
                                    <td>
                                        {{ $p['duesTotal'] }} @lang('SAR')
                                    </td>
                                    <td>
                                        {{ $p['count'] }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.providers.approved',$list->id) }}">
                                            {!! $list->showStatus() !!}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $list->vat }} %
                                    </td>
                                    <td>
                                        {{ $list->commission_price }} %
                                    </td>
                                    <td>
                                        {{ $list->created_at}}
                                    </td>
                                    <td style="display: inline-flex;">
                                        <a style="@if(\App::getLocale() == 'ar') margin-left: 5px; @else margin-right: 5px; @endif"
                                            class="btn btn-outline-secondary btn-sm edit"
                                            href="{{ route('admin.providers.edit',$list->id) }}">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                        {!! action_table_delete(route('admin.providers.destroy',$list->id),$list->id) !!}
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
        <form action="{{ route('admin.providers.index') }}" method="get" enctype="multipart/form-data">

            <div class="mb-3 row">
                <div class="col-md-12">
                    <input class="form-control" value="{{ request('name','') }}" name="name" type="name" placeholder="@lang('Search by name or email')" id="example-text-input">
                </div>
            </div>
            <div class="row" style=" margin-top: 20px; ">
                <div style="text-align: right">
                    <a href="{{ route('admin.providers.index') }}" style=" float: left; " class="btn btn-primary w-md">
                        @lang('Reset')
                    </a>
                    <button type="submit" class="btn btn-primary w-md">@lang('Submit')</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Static Backdrop Modal -->
<div class="modal fade" id="MMI" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="MMILabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="MMILabel">
                    @lang('Change Vat & Commission')
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.providers.change-vat') }}" method="post">
                <div class="modal-body">
                    <div class="">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">@lang('Provider Name')</th>
                                            <th scope="col">@lang('Vat')</th>
                                            <th scope="col">@lang('Commission')</th>
                                        </tr>
                                    </thead>
                                    <tbody id="RowProviderShow">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('Close')</button>
                    @csrf
                    <button type="submit" class="btn btn-primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script>
        $('.my-action').click(function(){ $('#offcanvasWithBothOptionsLabel').html($(this).data('title')); });
    </script>
    <script type="template/product" id="product_template">
        <tr>
            <td>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" readonly id="floatingNameInput" value="NAME">
                    <label for="floatingNameInput">@lang('Name')</label>
                </div>
            </td>
            <td>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingVatInput" name="data[ID][v]" value="VAT">
                    <label for="floatingVatInput">@lang('VAT')</label>
                </div>
            </td>
            <td>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingCommissionInput" name="data[ID][c]" value="COMMISSION">
                    <label for="floatingCommissionInput">@lang('Commission')</label>
                </div>
            </td>
        </tr>
    </script>

    <script>
        $('.open-modal').click(function(){
            $('#RowProviderShow').html(' ');
            var ids = new Array();
            $('input[name="ids"]:checked').each(function() {
                ids.push(this.value);
            });
            if(typeof ids !== 'undefined' && ids.length > 0) {
                $(ids).each(function() {
                    var arr = jQuery.parseJSON(this);
                    var product_template = $('#product_template').text().replace("ID",arr.id).replace("NAME",arr.name).replace("ID",arr.id).replace("VAT",arr.vat).replace("COMMISSION",arr.commission_price);
                    $('#RowProviderShow').append(product_template);
                });
                $('#MMI').modal("toggle");
            } else {
                toastr["warning"]("برجاء تحديد المراكز اولا")
            }
        });
    </script>
@endpush
