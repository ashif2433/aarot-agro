<!DOCTYPE html><html lang="en">

<head>
    @include('layouts.frontend.partials.meta')@include('layouts.global')@include('layouts.frontend.partials.style')@php echo setting('fb_pixel');@endphp{{-- <!-- Custom Head Code --> --}}@php echo setting('header_code');@endphp
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
</head>

<body{{--  class="" --}}>@php echo setting('body_code');@endphp
{{-- Facebook SDK --}}
@if (env('FACEBOOK_SKD_ON') == 1)
    <div id="fb-root"></div>
    <div id="fb-customer-chat" class="fb-customerchat"></div>
    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "523283677850901");
        chatbox.setAttribute("attribution", "biz_inbox");
    </script>
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                xfbml: true,
                version: 'v13.0'
            });
        };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <style>
        .fb_dialog_content iframe {
            bottom: 105px !important;
        }
    </style>
@endif
{{-- Top Header Style --}}
@if (!empty(setting('TOP_HEADER_STYLE')))
@include('layouts.frontend.partials.header_' . setting('TOP_HEADER_STYLE'))
@else
@include('layouts.frontend.partials.header_1')
@endif

@yield('content')
@include('layouts.frontend.partials.footer')
<!-- OVERRIDE CSS _@stack('override_css') --><style>@stack('override_css'){{ setting('override_css') }}</style>
@include('layouts.frontend.partials.script')

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init({
        duration: 1200,
        once: true,
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const slider = document.querySelector(".team-slider");
    const track = document.querySelector(".team-track");

    let isDown = false;
    let startX;
    let scrollLeft;

    /* MOUSE DRAG EVENTS */
    slider.addEventListener("mousedown", (e) => {
        isDown = true;
        slider.classList.add("dragging");
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener("mouseleave", () => {
        isDown = false;
        slider.classList.remove("dragging");
    });

    slider.addEventListener("mouseup", () => {
        isDown = false;
        slider.classList.remove("dragging");
    });

    slider.addEventListener("mousemove", (e) => {
        if(!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2; // drag speed
        slider.scrollLeft = scrollLeft - walk;
    });


    /* TOUCH SWIPE EVENTS */
    slider.addEventListener("touchstart", (e) => {
        isDown = true;
        startX = e.touches[0].pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener("touchend", () => {
        isDown = false;
    });

    slider.addEventListener("touchmove", (e) => {
        if(!isDown) return;
        const x = e.touches[0].pageX - slider.offsetLeft;
        const walk = (x - startX) * 2;
        slider.scrollLeft = scrollLeft - walk;
    });

});
</script>

</body>
</html>
