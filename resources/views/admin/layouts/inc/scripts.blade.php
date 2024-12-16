<div class="rightbar-overlay"></div>
<script src="{{ url('/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ url('/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ url('/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ url('/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ url('/assets/libs/toastr/build/toastr.min.js') }}"></script>
<script src="{{ url('/assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ url('/assets/js/pages/toastr.init.js') }}"></script>
<script src="{{ url('/assets/js/app.js') }}"></script>


<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 1000,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>
@if (Session::get('success'))
    <script>
        toastr["success"]("{{ Session::get('success') }}")
    </script>
@endif
@if (Session::get('danger'))
    <script>
        toastr["warning"]("{{ Session::get('danger') }}")
    </script>
@endif




<!-- Static Backdrop Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    @lang('Delete This row')
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    @lang('Are you sure, You want to delete this row')
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('No')</button>
                <button type="button" class="btn btn-primary actionMyDelete">@lang('Yes')</button>
            </div>
        </div>
    </div>
</div>

<script>
    var row_deleted = 0;
    $('.row_deleted').click(function(e){
        e.preventDefault();
        row_deleted = $(this).data('id');
    });
    $('.actionMyDelete').click(function(e){
        e.preventDefault();
        $('#form_'+row_deleted).submit();
    });
</script>

@stack('scripts')
@stack('end_scripts')
