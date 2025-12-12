@extends('layouts.frontend.app')

@section('title', 'About Us')

@section('content')

<link rel="stylesheet" href="{{ asset('css/about.css') }}">

{{-- <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init({
        duration: 1200,
        once: true,
    });
</script> --}}

<div class="aboutHeroBg">

    {{-- ============================
        ZONE 1 (PLANT IMAGE BG)
    ============================== --}}
    <div class="zone-1">
            <!-- Background Video -->
            <video class="zone1-video" autoplay muted loop playsinline>
                <source src="{{ asset('uploads/4.mp4') }}" type="video/mp4">
            </video>

        <div class="about-wrapper">

            {{-- ============================
                 ABOUT SECTION
            ============================== --}}
            @foreach (['about-us'] as $section)
                @if(isset($data[$section]))
                    @foreach($data[$section] as $item)

                        <section class="type-two"
                            data-aos="slide-left"
                            data-aos-delay="150">

                            <div class="about-image" data-aos="pop-top">
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}">
                                @endif
                            </div>

                            <div class="about-text">
                                <h2 class="section-title">{{ ucfirst(str_replace('-', ' ', $section)) }}</h2>
                                <p>{!! $item->description !!}</p>
                            </div>

                        </section>

                    @endforeach
                @endif
            @endforeach


            {{-- ============================
                AT A GLANCE
            ============================== --}}
            @foreach (['at-a-glance'] as $section)
                @if(isset($data[$section]))
                    @foreach($data[$section] as $item)

                        <section class="type-one"
                            data-aos="inside-out"
                            data-aos-delay="150">
{{--
                            <div class="about-image">
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}">
                                @endif
                            </div> --}}

                            <div class="about-text">
                                <h2 class="section-title">{{ ucfirst(str_replace('-', ' ', $section)) }}</h2>
                                <p>{!! $item->description !!}</p>
                            </div>

                        </section>

                    @endforeach
                @endif
            @endforeach


            {{-- ============================
                MISSION
            ============================== --}}
            @foreach (['mission'] as $section)
                @if(isset($data[$section]))
                    @foreach($data[$section] as $item)

                        <section class="type-one"
                            data-aos="slide-left"
                            data-aos-delay="200">

                            <div class="about-image">
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}">
                                @endif
                            </div>

                            <div class="about-text">
                                <h2 class="section-title">{{ ucfirst(str_replace('-', ' ', $section)) }}</h2>
                                <p>{!! $item->description !!}</p>
                            </div>

                        </section>

                    @endforeach
                @endif
            @endforeach


            {{-- ============================
                VISION
            ============================== --}}
            @foreach (['vision'] as $section)
                @if(isset($data[$section]))
                    @foreach($data[$section] as $item)

                        <section class="type-two"
                            data-aos="slide-right"
                            data-aos-delay="200">

                            <div class="about-image">
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}">
                                @endif
                            </div>

                            <div class="about-text">
                                <h2 class="section-title">{{ ucfirst(str_replace('-', ' ', $section)) }}</h2>
                                <p>{!! $item->description !!}</p>
                            </div>

                        </section>

                    @endforeach
                @endif
            @endforeach

        </div>
    </div>




    {{-- ============================
        ZONE 2 (LIGHT GRAY BG)
    ============================== --}}
    <div class="zone-2">
        <div class="about-wrapper">

            {{-- ============================
                INSPIRATION
            ============================== --}}
            @if(isset($data['inspiration']))
                <section class="about-title-center">
                    <p class="section-title">Inspiration</p>
                </section>

                @foreach($data['inspiration'] as $item)

                    <section class="type-one-1">

                        <div class="about-image-2" data-aos="slide-left">
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}">
                            @endif
                        </div>

                        <div class="about-text" data-aos="slide-right">
                            <h3>{{ $item->title }}</h3>
                            <p>{!! $item->description !!}</p>
                        </div>

                    </section>

                @endforeach
            @endif



            {{-- ============================
                FOUNDER
            ============================== --}}
            @if(isset($data['founder']))
                <section class="about-title-center">
                    <h1 class="section-title">Founder</h1>
                </section>

                <div class="founder-grid">
                    @foreach($data['founder'] as $item)

                        <section class="type-one-1">

                            <div class="founder-card"
                                data-aos="zoom-in"
                                data-aos-delay="200">

                                <img src="{{ asset('storage/'.$item->image) }}"
                                    class="founder-img"
                                    data-aos="pop-top">

                                <h3>{{ $item->title }}</h3>
                                <p>{!! $item->description !!}</p>

                            </div>

                        </section>

                    @endforeach
                </div>
            @endif

        </div>
    </div>




    {{-- ============================
        ZONE 3 (BLACK BG)
    ============================== --}}
    <div class="zone-3">
        <div class="about-wrapper">

            {{-- ============================
                ADVISOR SECTION
            ============================== --}}
            @if(isset($data['advisor']))
                <section class="about-title-center">
                    <h1 class="section-title-1">Advisor</h1>
                </section>

                <div class="advisor-grid">

                    @foreach($data['advisor'] as $item)
                        <div class="advisor-card"
                            data-aos="zoom-in"
                            data-aos-id="advisor"
                            data-aos-delay="{{ $loop->index * 150 }}">

                            <img src="{{ asset('storage/'.$item->image) }}">

                            {{-- Only 1st advisor has no link --}}
                            @if($loop->iteration == 1)
                                <h4>{{ $item->title }}</h4>
                            @else
                                <h4 style="display:flex; align-items:center; justify-content:center; gap:7px;">
                                    {{ $item->title }}
                                    @if(!empty($item->link))
                                        <a href="{{ $item->link }}" class="advisor-link advisor-icon" target="_blank">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    @endif
                                </h4>
                            @endif
                            <p>{!! $item->description !!}</p>
                        </div>
                    @endforeach
                </div>
            @endif



            {{-- ============================
                TEAM SECTION
            ============================== --}}
            <div class="about-title-center">
                    <h1 class="section-title-1">Team</h1>
                </div>
            <div class="team-slider" data-aos="zoom-in">
                <div class="team-track">
                    @foreach($data['team'] as $item)
                        <div class="team-card">
                            <img src="{{ asset('storage/'.$item->image) }}">
                            <h4>{{ $item->title }}</h4>
                            <p>{!! $item->description !!}</p>
                        </div>
                    @endforeach

                    {{-- Duplicate items to allow infinite loop --}}
                    @foreach($data['team'] as $item)
                        <div class="team-card">
                            <img src="{{ asset('storage/'.$item->image) }}">
                            <h4>{{ $item->title }}</h4>
                            <p>{!! $item->description !!}</p>
                        </div>
                    @endforeach
                </div>
            </div>


        </div>
    </div>

</div>

@endsection
