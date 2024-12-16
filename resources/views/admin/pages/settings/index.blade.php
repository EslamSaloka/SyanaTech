@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

<div class="checkout-tabs">
    <div class="row">
        <div class="col-xl-2 col-sm-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                @foreach ($lists as $key=>$value)
                    <a class="nav-link {{ ($loop->index == 0)? 'active': '' }}" id="v-pills-{{$key}}-tab" 
                        data-bs-toggle="pill" 
                        href="#v-pills-{{$key}}" 
                        role="tab" 
                        aria-controls="v-pills-{{$key}}" 
                        aria-selected="true">
                        <i class= "bx {{$value['icon']}} d-block check-nav-icon mt-4 mb-2"></i>
                        <p class="fw-bold mb-4">{{ __($value['title']) }}</p>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-xl-10 col-sm-9">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="v-pills-tabContent">
                        @foreach ($lists as $key=>$value)
                            <div class="tab-pane fade {{ ($loop->index == 0)? 'show active': '' }}" id="v-pills-{{$key}}" role="tabpanel" aria-labelledby="v-pills-{{$key}}-tab">
                                <div>
                                    <form action="{{ route('admin.settings.update',$key) }}" method="post" enctype="multipart/form-data">
                                        @isset($value['form']['group'])
                                            @includeIf('admin.pages.settings.inc.more',['data'=>$value['form']['group'],'group_by'=>$key])
                                        @else
                                            @isset($value['form']['lang'])
                                                @includeIf('admin.pages.settings.inc.lang',['form'=>$value['form'],'group_by'=>$key])
                                            @endisset
                                            @includeIf('admin.pages.settings.inc.inputs',['form'=>$value['form']])
                                        @endisset
                    
                                        <div class="row" style=" margin-top: 20px; ">
                                            @csrf
                                            @method('PUT')
                                            <div style="text-align: right">
                                                <button type="submit" class="btn btn-primary w-md">@lang('Submit')</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





@endsection
@push('scripts')

@endpush