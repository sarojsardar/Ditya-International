<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div
            class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                {{ @$setting->site_name ? @$setting->site_name : config('app.name') }}
            </div>
            <div class="d-none d-lg-inline-block">

            </div>
        </div>
    </div>
</footer>
