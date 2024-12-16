@extends('admin.layouts.master')
@section('title')@lang('Dashboard') @endsection
@section('PageContent')
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                @foreach ($statistic as $item)
                    <div class="col-lg-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">{{$item['title']}}</p>
                                        <h4 class="mb-0">{{$item['count']}}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx {{$item['icon']}} font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        <h2>@lang('Orders')</h2>
        <div class="col-lg-12">
            <div class="row">
                @foreach ($orders as $item)
                    <div class="col-lg-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">{{$item['title']}}</p>
                                        <h4 class="mb-0">{{$item['count']}}</h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx {{$item['icon']}} font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush