@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.providers.store') }}" method="post" enctype="multipart/form-data">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingNameInput" name="provider_name" placeholder="@lang('Provider Name')" value="{{ old('provider_name') }}">
                        <label for="floatingNameInput">@lang('Provider Name')</label>
                        @error('provider_name')
                            <span style="color:red;">
                                {{ $errors->first('provider_name') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingEmailInput" name="email" placeholder="@lang('Email')" value="{{ old('email') }}">
                        <label for="floatingEmailInput">@lang('Email')</label>
                        @error('email')
                            <span style="color:red;">
                                {{ $errors->first('email') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingPhoneInput" name="phone" placeholder="@lang('Phone Number')" value="{{ old('phone') }}">
                        <label for="floatingPhoneInput">@lang('Phone Number')</label>
                        @error('phone')
                            <span style="color:red;">
                                {{ $errors->first('phone') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPasswordInput" name="password" placeholder="@lang('Password')" />
                        <label for="floatingPasswordInput">@lang('Password')</label>
                        @error('password')
                            <span style="color:red;">
                                {{ $errors->first('password') }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <label for="user_avatar" class="col-form-label col-lg-2">@lang('Image')</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="file" name="avatar" id="user_avatar">
                            @error('avatar')
                                <span style="color:red;">
                                    {{ $errors->first('avatar') }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <select name="how_to_know_us" class="form-select">
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingPriceInput">@lang('how_to_know_us')</label>
                        @error('how_to_know_us')
                            <span style="color:red;">
                                {{ $errors->first('how_to_know_us') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <select name="categories[]" multiple class="form-select">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingPriceInput">@lang('categories')</label>
                        @error('categories')
                            <span style="color:red;">
                                {{ $errors->first('categories') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <select name="factories[]" multiple class="form-select">
                            @foreach ($factories as $factory)
                                <option value="{{ $factory->id }}">{{ $factory->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingPriceInput">@lang('factories')</label>
                        @error('factories')
                            <span style="color:red;">
                                {{ $errors->first('factories') }}
                            </span>
                        @enderror
                    </div>


                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingPhoneInput" name="commercial_registration_number" placeholder="@lang('commercial_registration_number')" value="{{ old('commercial_registration_number') }}">
                        <label for="floatingPhoneInput">@lang('commercial_registration_number')</label>
                        @error('commercial_registration_number')
                            <span style="color:red;">
                                {{ $errors->first('commercial_registration_number') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingPhoneInput" name="tax_number" placeholder="@lang('tax Number')" value="{{ old('tax_number') }}">
                        <label for="floatingPhoneInput">@lang('Tax Number')</label>
                        @error('tax_number')
                            <span style="color:red;">
                                {{ $errors->first('tax_number') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingPhoneInput" name="lat" placeholder="@lang('LAT')" value="{{ old('lat') }}">
                        <label for="floatingPhoneInput">@lang('LAT')</label>
                        @error('lat')
                            <span style="color:red;">
                                {{ $errors->first('lat') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingPhoneInput" name="lng" placeholder="@lang('LNG')" value="{{ old('lng') }}">
                        <label for="floatingPhoneInput">@lang('LNG')</label>
                        @error('lng')
                            <span style="color:red;">
                                {{ $errors->first('lng') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <textarea name="terms" placeholder="@lang('Terms')" class="form-control" id="floatingPhoneInput" cols="30" rows="30">{{ old('terms') }}</textarea>
                        <label for="floatingPhoneInput">@lang('terms')</label>
                        @error('terms')
                            <span style="color:red;">
                                {{ $errors->first('terms') }}
                            </span>
                        @enderror
                    </div>


                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingVatInput" name="vat" placeholder="@lang('Vat') 0%" value="{{ old('vat') }}">
                        <label for="floatingVatInput">@lang('Vat') 0%</label>
                        @error('vat')
                            <span style="color:red;">
                                {{ $errors->first('vat') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingcommissionInput" name="commission_price" placeholder="@lang('Commission')" value="{{ old('commission_price') }}">
                        <label for="floatingcommissionInput">@lang('Commission')</label>
                        @error('commission_price')
                            <span style="color:red;">
                                {{ $errors->first('commission_price') }}
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

