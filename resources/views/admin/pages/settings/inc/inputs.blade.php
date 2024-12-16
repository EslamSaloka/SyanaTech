@isset($form['inputs'])
    @foreach ($form['inputs'] as $item)
        @if ($item['type'] == 'select')
            
        @elseif ($item['type'] == 'image')
        <div class="mb-3 row">
            <label for="user_avatar" class="col-form-label col-lg-2">@lang($item['label'])</label>
            <div class="col-lg-9">
                <input class="form-control" type="file" name="{{ $item['name'] }}" id="user_avatar">
                @error($item['name'])
                    <span style="color:red;">
                        {{ $errors->first($item['name']) }}
                    </span>
                @enderror
            </div>
            <div class="col-lg-1">
                <img src="{{ getSettings($item['name']) }}" alt="" class="rounded-circle header-profile-user">
            </div>
        </div>
        @else
            <div class="mb-3 row">
                <label for="{{ $item['name'] }}-input" class="col-md-2 col-form-label">{{ __($item['label']) }}</label>
                <div class="col-md-10">
                    <input 
                        class="form-control" 
                        type="{{$item['type']}}" 
                        value="{{ getSettings($item['name']) }}" 
                        name="{{ $item['name'] }}" 
                        placeholder="{{ __($item['placeholder']) }}"
                        @if (isset($item["attr"]))
                            @foreach ($item["attr"] as $o=>$i)
                                {{ $o."=".$i }} 
                            @endforeach
                        @endif 
                        id="{{ $item['name'] }}-input">
                    @error($item['name'])
                    <span style="color:red;">
                            {{ $errors->first($item['name']) }}
                        </span>
                    @enderror
                </div>
            </div>
        @endif
    @endforeach
@endisset