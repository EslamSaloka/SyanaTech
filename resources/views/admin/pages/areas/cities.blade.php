<?php 
    if($cities->count() == 0) {
        return "";
    }
?>
<div class="form-floating mb-3">
    <select name="city" class="form-select">
        @foreach ($cities as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
    </select>
    <label for="floatingPriceInput">@lang('City')</label>
    @error('city')
        <span style="color:red;">
            {{ $errors->first('city') }}
        </span>
    @enderror
</div>