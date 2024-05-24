<!-- Footer  -->
<footer class="footer">
    <div class="container">
        <div class="footer-wrap">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-content">
                        <div class="footer-logo footer-col">
                            <h3>About {{ explode(' ', @$setting->site_name)[0] }}</h3>
                        </div>
                        <p>
                            {!! \Illuminate\Support\Str::limit(@$webContent->about_us_content, 150, $end = '...') !!}
                        </p>
                        <ul>
                            <li>
                                <a href="{{ @$setting->fb_link }}" target="_blank"><img src="{{asset('assets/images/social-media/facebook.png')}}" alt="images"></a>
                            </li>
                            <li>
                                <a href="{{ @$setting->insta_link }}" target="_blank"><img src="{{asset('assets/images/social-media/instagram.png')}}" alt="images"></a>
                            </li>
                            <li>
                                <a href="{{ @$setting->tiktok_link }}" target="_blank"><img src="{{asset('assets/images/social-media/tiktok.png')}}" alt="images"></a>
                            </li>
                            <li>
                                <a href="{{ @$setting->whatsapp }}" target="_blank"><img src="{{asset('assets/images/social-media/whatsapp.png')}}" alt="images"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-col space1">
                        <h3>Quick Links</h3>
                        <ul>
                            <li><a href="{{ route('web.aboutUs') }}">About Us</a></li>
                            <li><a href="{{ route('web.services') }}">Services</a></li>
                            <li><a href="{{ route('web.privacyPolicy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('web.termsAndConditions') }}">Terms & Conditions</a></li>
                            <li><a href="{{ route('web.contactUs') }}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="footer-col space2">
                        <h3>Our Services</h3>
                        <ul>
                            @foreach ($services->take(6) as $service)
                                <li><a href="{{ route('web.singleService', $service->slug) }}">{{ $service->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.546433095541!2d85.3478238751941!3d27.700410125797887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19ca9ef2bf45%3A0xe4397364f359189!2sDitya%20International%20Manpower!5e0!3m2!1sen!2snp!4v1691675528093!5m2!1sen!2snp"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>All rights reserved. {{ @$setting->site_name }}. © {{ \Carbon\Carbon::today()->format('Y') }}</p>
        </div>
    </div>
</footer>
<!-- Footer End  -->

<script src="{{ asset('web/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('web/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script src="{{ asset('web/js/lightgallery-all.min.js') }}"></script>
<script src="{{ asset('web/js/popper.min.js') }}"></script>
<script src="{{ asset('web/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('web/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('web/js/animation.js') }}"></script>
<script src="{{ asset('web/js/slick.min.js') }}"></script>
<script src="{{ asset('web/js/custom.js') }}"></script>
</body>

</html>
