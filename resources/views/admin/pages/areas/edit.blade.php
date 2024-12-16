@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.areas.update',$area->id) }}" method="post" enctype="multipart/form-data">

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
                                            placeholder="{{ __('Name') }} @lang('Of') {{ $value['name'] }}"
                                            value="{{ old('name',$area->translate($key)->name ?? '') }}">
                                            <label for="floatingNameInput">{{ __('Name') }} @lang('Of') {{ $value['name'] }}</label>
                                            @error($key.'.name')
                                                <span style="color:red;">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <select name="parent" class="form-select">
                            <option value="0">{{ __('Parent') }}</option>
                            @foreach ($items as $item)
                                <option @if ($area->parent == $item->id)
                                    selected
                                @endif value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingPriceInput">@lang('Parent')</label>
                        @error('parent')
                            <span style="color:red;">
                                {{ $errors->first('parent') }}
                            </span>
                        @enderror
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

