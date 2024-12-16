@if (isset($breadcrumb))
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $breadcrumb['title'] }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home.index') }}">
                                @lang('Dashboard')
                            </a>
                        </li>
                        <?php
                            $last  = count($breadcrumb['items']);
                            $index = 1;
                        ?>
                        @foreach ($breadcrumb['items'] as $item)
                            @if ($index != $last)
                                <li class="breadcrumb-item">
                                    <a href="{{ $item['url'] }}">
                                        {{ $item['title'] }}
                                    </a>
                                </li>
                            @else
                                <li class="breadcrumb-item active">
                                    {{ $item['title'] }}
                                </li>
                            @endif
                            <?php $index++; ?>
                        @endforeach
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endif
