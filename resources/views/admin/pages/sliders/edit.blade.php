@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.sliders.update',$slider->id) }}" method="post" enctype="multipart/form-data">
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
                                            class="form-control @error($key.'.name') is-invalid @enderror"
                                            id="floatingNameInput"
                                            name="{{$key}}[name]"
                                            placeholder="{{ __('Enter type name') }}"
                                            value="{{ old('name',$slider->translate($key)->name ?? '') }}">
                                            <label for="floatingNameInput">{{ __('Name') }} @lang('Of') {{ $value['name'] }}</label>
                                            @error($key.'.name')
                                                <span style="color:red;">
                                                    {{ $errors->first($key.'.name') }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div class="form-floating mb-3">
                        <select name="provider_id" class="form-select">
                            <option value="0">{{ __('Choose Provider') }}</option>
                            @foreach ($providers as $provider)
                                <option @if ($slider->provider_id == $provider->id)
                                    selected
                                @endif value="{{ $provider->id }}">{{ $provider->provider_name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingPriceInput">@lang('provider')</label>
                        @error('provider_id')
                            <span style="color:red;">
                                {{ $errors->first('provider_id') }}
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
                            <img src="{{ display_image_by_model($slider,'image') }}" alt="" class="rounded-circle header-profile-user">
                        </div>
                    </div>

                    <div class="row" style=" margin-top: 20px; ">
                        <div style="text-align: right">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary w-md">@lang('Submit')</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


@endsection
