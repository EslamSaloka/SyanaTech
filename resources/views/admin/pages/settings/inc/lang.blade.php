<?php 
    $sub = (isset($sub)) ? rand(100,999) : 0;
?>
<div class="row">
    <div class="col-md-3">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            @foreach (config('laravellocalization.supportedLocales') as $key=>$value)
                <a class="nav-link mb-2 {{ ($loop->index == 0)? 'active': '' }}" 
                        id="v-pills-{{$key}}-{{$sub}}-tab" 
                        data-bs-toggle="pill" 
                        href="#v-pills-{{$key}}-{{$sub}}" 
                        role="tab" 
                        aria-controls="v-pills-{{$key}}-{{$sub}}" 
                        aria-selected="true">
                    {{ $value['name'] }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
            @foreach (config('laravellocalization.supportedLocales') as $key=>$value)
                <div class="tab-pane fade {{ ($loop->index == 0)? 'show active': '' }}" id="v-pills-{{$key}}-{{$sub}}" role="tabpanel" aria-labelledby="v-pills-{{$key}}-{{$sub}}-tab">
                    
                    @foreach ($form['lang']['inputs'] as $item)
                        <?php 
                            $value = \App\Models\Setting::where([
                                'key'       => $item['name'],
                                'group_by'  => $group_by
                            ])->first();
                            if(is_null($value)) {
                                $value = '';
                            } else {
                                $value = $value->translate($key)->value ?? '';
                            }
                        ?>
                        @if ($item['type'] == 'textarea')
                            <div class="form-floating mb-3">
                                <textarea id="floating{{$item['name']}}Input" class="form-control" cols="30" rows="10" name="{{$key}}[{{ $item['name'] }}]" placeholder="{{ __($item['placeholder']) }}">{{ $value }}</textarea>
                                <label for="floating{{$item['name']}}Input">{{ __($item['label']) }}</label>
                                @error($item['name'])
                                    <span style="color:red;">
                                        {{ $errors->first($item['name']) }}
                                    </span>
                                @enderror
                            </div>
                        @else   

                            <div class="form-floating mb-3">
                                <input type="{{$item['type']}}" 
                                        class="form-control" 
                                        id="floating{{$item['name']}}Input" 
                                        placeholder="{{ __($item['placeholder']) }}" 
                                        name="{{$key}}[{{$item['name']}}]"
                                        value="{{ $value }}">
                                <label for="floating{{$item['name']}}Input">{{ __($item['label']) }}</label>
                                @error($item['name'])
                                    <span style="color:red;">
                                        {{ $errors->first($item['name']) }}
                                    </span>
                                @enderror
                            </div>


                        @endif
                    @endforeach


                </div>
            @endforeach

        </div>
    </div>
</div>


<hr>