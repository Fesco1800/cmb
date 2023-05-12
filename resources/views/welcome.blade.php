<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Celebrity Men's Barbershop </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/tab-icon.png">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animated-headline.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body onload="loadAnnouncement()">

    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/loder.png" alt="">
                </div>
            </div>
        </div>
    </div>

    <header>

        <div class="header-area header-transparent pt-20">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo" style="width: 120px;">
                            <a href=""><img src="{{ $details->logo_url ?? 'assets/img/logo/logo.png' }}" alt="" style="width: 100%;"></a>
                        </div>
                        <div class="menu-main d-none d-md-block">
                            <div class="main-menu d-flex align-items-center">
                                <nav>
                                    <ul id="navigation">
                                        <li class="home_nav active"><a href="">Home</a></li>
                                        <li class="branch_nav"><a href="#" >Branch</a></li>
                                        <li class="service_nav"><a href="#">Services</a></li>
                                        <li class="about_nav"><a href="#">About</a></li>
                                        <li class="contact_nav"><a href="#">Contact</a></li>
                                    </ul>
                                </nav>
                                <div class="header-right-btn f-right d-none d-md-block">
                                    <a href="{{ route('login') }}" class="btn header-btn">Login</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-block d-md-none">
                            <button id="mobile_button" style="padding: 0.25rem 0.75rem; background: transparent; border:none; cursor:pointer;" onclick="showMenu()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <main>

        @include('components.modals.announcementModal', ['details' => $details])
        <div class="slider-area position-relative fix" id="cmbback" style="background-image: url({{ $details->header_bg_image_url ?? 'assets/img/hero/h1_hero.png' }})">

            <div class="stock-text">
                <h2>{{ $details->header_label ?? 'get more confident' }}</h2>
                <h2>{{ $details->header_label ?? 'get more confident' }}</h2>
            </div>

            <div class="appointment-wrapper">
                <a href="{{ route('login') }}" class="btn header-btn">Make appointment</a>
            </div>

        </div>

        <section class="team-area section-padding position-relative" id="branch">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-8 col-md-11 col-sm-11">
                        <div class="section-tittle text-center mb-100">
                            <span>{{ $details->branch_title ?? 'Our Branches' }}</span>
                            <h2>{{ $details->branch_subtitle ?? 'Check out our list of branches' }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row team-active dot-style">

                    @foreach ($branches as $branch)
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                            <div class="single-team mb-80 text-center">
                                <div class="team-img">
                                    <h2 class="branchOpenClose">Open:{{ $branch->branch_open }} Close:{{ $branch->branch_close }}</h2>
                                    <span style=""></span>
                                    <a href="{{ $branch->google_link }}" target="_blank">  
                                        <img src="{{ asset('images/branch_images/') .'/'. $branch->branch_img }}" alt="">
                                    </a>
                                </div>
                                <div class="team-caption">
                                    <span>{{ $branch->branch_location }}</span>
                                    <h3><a href="#">{{ $branch->branch_name }}</a></h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="service-area section-padding position-relative" id="services">
            <div class="container">

                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-11 col-sm-11">
                        <div class="section-tittle text-center mb-90">
                            <span>{{ $details->service_title ?? 'Professional Services' }}</span>
                            <h2>{{ $details->service_subtitle ?? 'Our Best services that we offering to you' }}</h2>
                        </div>
                    </div>
                </div>

                <div class="row">

                    @foreach ($services as $service)

                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="services-caption text-center mb-30">
                                <div class="service-icon">
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-scissors" viewBox="0 0 16 16">
                                            <path d="M3.5 3.5c-.614-.884-.074-1.962.858-2.5L8 7.226 11.642 1c.932.538 1.472 1.616.858 2.5L8.81 8.61l1.556 2.661a2.5 2.5 0 1 1-.794.637L8 9.73l-1.572 2.177a2.5 2.5 0 1 1-.794-.637L7.19 8.61 3.5 3.5zm2.5 10a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0zm7 0a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0z"/>
                                        </svg>
                                    </i>
                                </div>
                                <div class="service-cap">
                                    <h4><a href="#">{{ $service->title }}</a></h4>
                                    <p> {{ $service->description }} </p>
                                </div>
                            </div>
                        </div>
                    
                    @endforeach
                </div>
            </div>
        </section>

        <section class="about-area section-padding position-relative" id="about">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-11">
                        <div class="about-img" > 
                            {{-- style="width: 500px;height: 500px;margin: auto;" --}}
                            <img src="{{ $details->about_img ?? 'assets/img/gallery/about.png' }}" alt="" style="width: 100%; height: 100%;">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="about-caption">

                            <div class="section-tittle section-tittle3 mb-35">
                                <span>{{ $details->about_title ?? 'About Our company' }}</span>
                                <h2>{{ $details->about_subtitle ?? '52 Years Of Experience In Hair cut!' }}</h2>
                            </div>
                            <p class="mb-30 pera-bottom">
                                {{ $details->about_description ?? 'Brook presents your services with flexible, convenient and
                                cdpoe layouts. You can select your favorite layouts & elements for cular ts with
                                unlimited ustomization possibilities. Pixel-perfreplication of the designers is
                                intended.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="about-shape">
                <img src="assets/img/gallery/about-shape.png" alt="">
            </div>
        </section>

        <section class="contact-us section-padding position-relative" id="contact">
            <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Get in Touch</h2>
                </div>
                <div class="col-lg-8">
                    <form class="form-contact contact_form" action="{{ route('contactmessage.store') }}" method="post"
                        id="contactForm">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="fullname" id="name" type="text"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'"
                                        placeholder="Enter your name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="email" id="email" type="email"
                                        onfocus="this.placeholder = ''"
                                        onblur="this.placeholder = 'Enter email address'" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="subject" id="subject" type="text"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'"
                                        placeholder="Enter Subject" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'"
                                        placeholder=" Enter Message" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="button button-contactForm boxed-btn">Send</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3>{{ $details->contact_address_label ?? 'Buttonwood, California.' }}</h3>
                            <p>{{ $details->contact_address_details ?? 'Rosemead, CA 91770' }}</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3>{{ $details->contact_mobile_number ?? '+1 253 565 2365' }}</h3>
                            <p>{{ $details->contact_availability ?? 'Mon to Fri 9am to 6pm' }}</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3>{{ $details->contact_email ?? 'test@mail.com' }}</h3>
                            <p>{{ $details->contact_email_details ?? 'Send us your query anytime!' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
    <footer>

        <div class="footer-area section-bg" data-background="assets/img/gallery/footer_bg.png">
            <div class="container">
                <div class="footer-top footer-padding">
                    <div class="row d-flex justify-content-between">
                        <div class="col-xl-7">
                            <div class="single-footer-caption mb-50">

                                <div class="footer-logo" style="width: 120px;">
                                    <a href="#"><img style="width: 100%;" src="{{ $details->logo_url ?? 'assets/img/logo/logo.png' }}" alt=""></a>
                                </div>
                                <div class="footer-tittle">
                                    <div class="footer-pera">
                                        <p class="info1">{{ $details->footer_description ?? 'We warmly welcome you to learn more about our product! You can find additional information by visiting our social media platforms - simply click on the social icons located in the bottom right corner of this footer. We also encourage you to read our user manual and privacy statement to ensure you get the most out of your experience with our product.' }}</p>
                                    </div>

                                </div>
                                <h4 style="color: #7c7c7c; font-weight: bold; margin-bottom: 10px;">Also Read:</h4>
                                <div class="user-manual">
                                        <a href="{{ !empty($details->footer_manual_link) ? $details->footer_manual_link : 'No manual' }}" target="_blank" style="font-size: 12px; color: #7c7c7c;" download>User Manual</a>
                                </div>
                                <div class="privacy-statement">
                                        <a href="{{ !empty($details->footer_privacy_link) ? $details->footer_privacy_link : 'No Data Privacy Statement' }}" target="_blank" style="font-size: 12px; color:#7c7c7c;">Data Privacy Statement</a>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-xl-9 col-lg-8">
                            <div class="footer-copy-right">
                                <p>
                                    Copyright &copy; CMB
                                    <script> document.write(new Date().getFullYear()); </script> All rights reserved
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4">

                                <div class="footer-social f-right">
                                    <a href="{{ $details->footer_twitter_url ?? null }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                    <a href="{{ $details->footer_facebook_url ?? null }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                    <a href="{{ $details->footer_instagram_url ?? null }}" target="_blank"><i class="fab fa-instagram"></i></a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </footer>

    <div class="menu-mobile d-none d-md-none">
         <div class="menu" style="padding: 120px 20px">
            <ul id="navigation">
                <li class="home_nav active" style="padding: 8px 20px"><a href="">Home</a></li>
                <li class="branch_nav" style="padding: 8px 20px"><a href="#" >Branch</a></li>
                <li class="service_nav" style="padding: 8px 20px"><a href="#">Services</a></li>
                <li class="about_nav" style="padding: 8px 20px"><a href="#">About</a></li>
                <li class="contact_nav" style="padding: 8px 20px"><a href="#">Contact</a></li>
            </ul>
         </div>                              
    </div>

    <div id="back-top" style="display:none;">
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>

    <script src="{{ asset('assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>

    <script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>

    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>

    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/animated.headline.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.js') }}"></script>

    <script src="{{ asset('assets/js/gijgo.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.sticky.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/hover-direction-snake.min.js') }}"></script>

    <!-- <script src="{{ asset('assets/js/contact.js') }}"></script> -->
    <script src="{{ asset('assets/js/jquery.form.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/mail-script.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>

    <script>
        var open_menu = false;

        function loadAnnouncement() {
            setTimeout(() => {
                $('#announcementModal').modal('show')
            }, 1000);
        }

        function showMenu() {
            open_menu = !open_menu;
            $('#mobile_button').empty()

            if (open_menu) {
                $('.menu-mobile').removeClass('d-none')
                $('#mobile_button').append(
                    `<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>`
                )
            }
            else {
                $('.menu-mobile').addClass('d-none')
                
                $('#mobile_button').append(
                    `<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                    </svg>`
                )
            }
        }
    </script>

    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
