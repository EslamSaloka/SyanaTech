<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                {{ date('Y') }} © {{ env('APP_NAME') }}.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    {{ env("APP_NAME") }}
                </div>
            </div>
        </div>
    </div>
</footer>