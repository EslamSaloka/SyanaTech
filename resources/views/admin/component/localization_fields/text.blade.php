<div class="form-floating mb-3">
    <input type="text"
    class="form-control @error($key.'.'.$input_name) is-invalid @enderror"
    id="floatingNameInput"
    name="{{$key}}[{{$input_name}}]"
    placeholder="{{ __('Enter type name') }}"
    value="{{ isset($value) ? $value->translate($key)->$input_name : old($key.'.'.$input_name) }}">
    <label for="floatingNameInput">{{ __('Name') }} @lang('Of') {{ $lang_name }}</label>
    @error($key.'.'.$input_name)
        <span style="color:red;">
            {{ $message }}
        </span>
    @enderror
</div>