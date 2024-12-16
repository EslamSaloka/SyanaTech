@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.cars.store') }}" method="post" enctype="multipart/form-data">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" 
                            id="floatingNameInput" 
                            name="vin" 
                            placeholder="@lang('VIN NUMBER')" 
                            value="{{ old('vin') }}">
                        <label for="floatingNameInput">@lang('VIN NUMBER')</label>
                        @error('vin')
                            <span style="color:red;">
                                {{ $errors->first('vin') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <select name="user_id" class="form-select">
                            <option value="0">{{ __('Choose Customer') }}</option>
                            @foreach ($customers as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }}</option>
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
                        <select name="color_id" class="form-select">
                            <option value="0">{{ __('Choose Color') }}</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingPriceInput">@lang('Color')</label>
                        @error('color_id')
                            <span style="color:red;">
                                {{ $errors->first('color_id') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <select name="car_country_factory_id" class="form-select">
                            <option value="0">{{ __('Choose Car Factories') }}</option>
                            @foreach ($factories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingPriceInput">@lang('Car Factories')</label>
                        @error('car_country_factory_id')
                            <span style="color:red;">
                                {{ $errors->first('car_country_factory_id') }}
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

