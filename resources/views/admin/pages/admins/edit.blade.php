@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

<div class="row">
    <div class="col-8 mx-auto mt-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.admins.update',$admin->id) }}" method="post" enctype="multipart/form-data">


                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingNameInput" name="first_name" placeholder="@lang('First Name')" value="{{ old('first_name',$admin->first_name) }}">
                        <label for="floatingNameInput">@lang('First Name')</label>
                        @error('first_name')
                            <span style="color:red;">
                                {{ $errors->first('first_name') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingNameInput" name="last_name" placeholder="@lang('Last Name')" value="{{ old('last_name',$admin->last_name) }}">
                        <label for="floatingNameInput">@lang('Last Name')</label>
                        @error('last_name')
                            <span style="color:red;">
                                {{ $errors->first('last_name') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingEmailInput" name="email" placeholder="@lang('Email')" value="{{ old('email',$admin->email) }}">
                        <label for="floatingEmailInput">@lang('Email')</label>
                        @error('email')
                            <span style="color:red;">
                                {{ $errors->first('email') }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingPhoneInput" name="phone" placeholder="@lang('Phone Number')" value="{{ old('phone',$admin->phone) }}">
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
                        <div class="col-lg-9">
                            <input class="form-control" type="file" name="avatar" id="user_avatar">
                            @error('avatar')
                                <span style="color:red;">
                                    {{ $errors->first('avatar') }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-1">
                            <img src="{{ display_image_by_model($admin,'avatar','first_name') }}" alt="" class="rounded-circle header-profile-user">
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

