@extends('admin.layouts.master')
@section('title',$breadcrumb['title'])
@section('PageContent')
@includeIf('admin.layouts.inc.breadcrumb')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body" style=" position: relative; ">
                <h5 class="font-size-15">@lang('Message Details') :</h5>
                <p class="text-muted">
                    {!! $contact_u->message !!}
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">

        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                @lang('Name')
                            </td>
                            <td>
                                @if ($contact_u->user->user_type == "customer")
                                    {{ $contact_u->user->first_name ?? '' }} {{ $contact_u->user->last_name ?? '' }}
                                @else
                                    {{ $contact_u->user->provider_name ?? '' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Email')
                            </td>
                            <td>
                                <a href="mailto:{{ $contact_u->user->email ?? '' }}">{{ $contact_u->user->email ?? '' }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Phone')
                            </td>
                            <td>
                                <a href="tel:{{ $contact_u->user->phone ?? '' }}">{{ $contact_u->user->phone ?? '' }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Type')
                            </td>
                            <td>
                                {{ __($contact_u->message_type) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Status')
                            </td>
                            <td>
                                {!! $contact_u->showStatus() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @lang('Created At')
                            </td>
                            <td>
                                {{ $contact_u->created_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="composemodal" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="composemodalTitle">@lang('New Message')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.contact-us.update',$contact_u->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <textarea id="email-editor" name="message" placeholder="@lang('Message')"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Send') <i class="fab fa-telegram-plane ms-1"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal -->


@endsection
@push('scripts')
    <script src="{{ url('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ url('assets/js/pages/email-editor.init.js') }}"></script>
@endpush