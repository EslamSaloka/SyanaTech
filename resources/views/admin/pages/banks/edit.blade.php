@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.banks.update',$bank->id) }}" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                @foreach (config('laravellocalization.supportedLocales') as $key=>$value)
                                    <a class="nav-link mb-2 {{ ($loop->index == 0)? 'active': '' }}"
                                            id="v-pills-{{$key}}-tab"
                                            data-bs-toggle="pill"
                                            href="#v-pills-{{$key}}"
                                            role="tab"
                                            aria-controls="v-pills-{{$key}}"
                                            aria-selected="true">
                                        {{ $value['name'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                @foreach (config('laravellocalization.supportedLocales') as $key=>$value)
                                    <div class="tab-pane fade {{ ($loop->index == 0)? 'show active': '' }}" id="v-pills-{{$key}}" role="tabpanel" aria-labelledby="v-pills-{{$key}}-tab">
                                        <div class="form-floating mb-3">
                                            <input type="text"
                                            class="form-control @error($key.'.bank_name') is-invalid @enderror"
                                            id="floatingNameInput"
                                            name="{{$key}}[bank_name]"
                                            placeholder="{{ __('Bank Name') }} @lang('Of') {{ $value['name'] }}"
                                            value="{{ old($key.'.bank_name',$bank->translate($key)->bank_name ?? '') }}">
                                            <label for="floatingNameInput">{{ __('Bank Name') }} @lang('Of') {{ $value['name'] }}</label>
                                            @error($key.'.bank_name')
                                                <span style="color:red;">
                                                    {{ $errors->first($key.'.bank_name') }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text"
                                            class="form-control @error($key.'.account_name') is-invalid @enderror"
                                            id="floatingNameInput"
                                            name="{{$key}}[account_name]"
                                            placeholder="{{ __('Account Name') }} @lang('Of') {{ $value['name'] }}"
                                            value="{{ old($key.'.account_name',$bank->translate($key)->account_name ?? '') }}">
                                            <label for="floatingNameInput">{{ __('Account Name') }} @lang('Of') {{ $value['name'] }}</label>
                                            @error($key.'.account_name')
                                                <span style="color:red;">
                                                    {{ $errors->first($key.'.account_name') }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" 
                            id="floatingNameInput" 
                            name="account_number" 
                            placeholder="@lang('Account Number')" 
                            value="{{ old('account_number',$bank->account_number) }}">
                        <label for="floatingNameInput">@lang('Account Number')</label>
                        @error('account_number')
                            <span style="color:red;">
                                {{ $errors->first('account_number') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" 
                            id="floatingNameInput" 
                            name="iban" 
                            placeholder="@lang('IBAN')" 
                            value="{{ old('iban',$bank->iban) }}">
                        <label for="floatingNameInput">@lang('IBAN')</label>
                        @error('iban')
                            <span style="color:red;">
                                {{ $errors->first('iban') }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <label for="user_avatar" class="col-form-label col-lg-2">@lang('Image')</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="file" name="image" id="user_avatar">
                            @error('image')
                                <span style="color:red;">
                                    {{ $errors->first('image') }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-1">
                            <img src="{{ display_image_by_model($bank,'image',"account_number") }}" alt="" class="rounded-circle header-profile-user">
                        </div>
                    </div>

                    <div class="row" style=" margin-top: 20px; ">
                        <div style="text-align: right">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-primary w-md">@lang('Submit')</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


@endsection

