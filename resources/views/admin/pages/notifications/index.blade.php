@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.notifications.store') }}" method="post" enctype="multipart/form-data">

                    <div class="form-floating mb-3">
                        <select name="user_id" class="form-select">
                            <option value="all">{{ __('All') }}</option>
                            <option value="all_providers">{{ __('All Providers') }}</option>
                            <option value="all_customers">{{ __('All Customers') }}</option>
                            @foreach ($users as $user)
                                @if ($user->user_type == "provider")
                                    <option value="{{ $user->id }}">{{ $user->provider_name }} - ( @lang('Provider') )</option>
                                @else
                                    <option value="{{ $user->id }}">{{ $user->first_name }} - ( @lang('Customer') )</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="floatingPriceInput">@lang('Customer')</label>
                        @error('user_id')
                            <span style="color:red;">
                                {{ $errors->first('user_id') }}
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-floating mb-3">
                        <textarea name="message" class="form-control" placeholder="@lang('Message')" id="floatingNameInput" cols="30" rows="10"></textarea>
                        <label for="floatingNameInput">@lang('Message')</label>
                        @error('message')
                            <span style="color:red;">
                                {{ $errors->first('message') }}
                            </span>
                        @enderror
                    </div>

                    

                    <div class="row" style=" margin-top: 20px; ">
                        <div style="text-align: right">
                            @csrf
                            <button type="submit" class="btn btn-primary w-md">@lang('Submit')</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('styles')
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        .select2-container {
            width: 100% !important;
            height: 20px !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="assets/libs/select2/js/select2.min.js"></script>
    <script src="assets/js/pages/form-advanced.init.js"></script>
    <script>
        $('select').select2();
    </script>
@endpush