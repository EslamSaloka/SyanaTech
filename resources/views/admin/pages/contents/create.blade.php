@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

<div class="row">
    <div class="col-12 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.contents.store') }}" method="post" enctype="multipart/form-data">
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
                                            class="form-control @error($key.'.title') is-invalid @enderror"
                                            id="floatingNameInput"
                                            name="{{$key}}[title]"
                                            placeholder="{{ __('Title') }} @lang('Of') {{ $value['name'] }}"
                                            value="{{ old($key.'.title') }}">
                                            <label for="floatingNameInput">{{ __('Title') }} @lang('Of') {{ $value['name'] }}</label>
                                            @error($key.'.title')
                                                <span style="color:red;">
                                                    {{ $errors->first($key.'.title') }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="ckeditor form-control @error($key.'.description') is-invalid @enderror"
                                            id="floatingNameInput"
                                            name="{{$key}}[description]"
                                            placeholder="{{ __('Description') }} @lang('Of') {{ $value['name'] }}">
                                                {{ old($key.'.description') }}
                                            </textarea>

                                            <label for="floatingNameInput">{{ __('Description') }} @lang('Of') {{ $value['name'] }}</label>
                                            @error($key.'.description')
                                                <span style="color:red;">
                                                    {{ $errors->first($key.'.description') }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="user_avatar" class="col-form-label col-lg-2">@lang('Image')</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="file" name="image" id="user_avatar">
                            @error('image')
                                <span style="color:red;">
                                    {{ $errors->first('image') }}
                                </span>
                            @enderror
                        </div>
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

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>
@endpush
