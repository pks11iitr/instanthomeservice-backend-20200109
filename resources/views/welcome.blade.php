
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Zapaak Home Services">
    <meta name="keywords" content="Mindit">
    <meta name="author" content="Mindit">

    <title>Zapaak Home Services</title>
    <link rel="icon" href="img/favicon.png">
    <!-- CSS Files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/responsive.css">

    <!-- Fonts icons -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

</head>

<body>
<!-- Header Starts -->
<header class="">
    <div class="top-menu">
        <div class="container">
            <div class="row">
                <div class="col-12 py-2">
            <span class="left">
              <a href="tel:+91-9876543210"><i class="fa fa-phone"></i>+91-9876543210</a>
            </span>
                    <span class="right">
              <a href="#"><i class="fa fa-envelope"></i> info@zapaakhomeservices.com</a>
            </span>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-default py-3">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar4" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a href="http://localhost/classiclab/" class="navbar-brand"><img src="img/logo.png" alt=""></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar4">
                <ul class="navbar-nav mr-auto w-100 justify-content-end clearfix">
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="#">Home</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="#about">About</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="#services">Services</a>--}}
{{--                    </li>--}}
                </ul>
            </div>
        </div>
    </nav>
    <div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif


        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif


        @if ($message = Session::get('warning'))
            <div class="alert alert-warning alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif


        @if ($message = Session::get('info'))
            <div class="alert alert-info alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
    </div>

</header>
<!-- Header ends -->
<!-- Section Starts -->
<section class="carousel">
    <div id="light-slider" class="carousel slide">
        <div id="carousel-area">
            <div id="carousel-slider" class="carousel slide" data-ride="carousel">

                <ol class="carousel-indicators">
                    <li data-target="#carousel-slider" data-slide-to="1" class="active"></li>
                    <li data-target="#carousel-slider" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner carousel-main" role="listbox">
                    <div class="carousel-item slider-img active">
                        <img src="img/ac-banner.jpg" alt="">
                    </div>
                    <div class="carousel-item slider-img">
                        <img src="img/cctv-banner.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Sections ends -->
<!-- Section Starts -->
<section id="about" class="about py-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 mx-auto mb-3 text-center">
                <div class="section-title">
                    <h4>Welcome to "Zapaak Home Services"</h4>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12 text-center">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
        </div>
    </div>
</section>
<!-- Sections ends -->
<!-- Section Starts -->
<section id="services" class="services py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 mb-3 mx-auto text-center">
                <div class="section-title">
                    <h4>Our Services</h4>
                </div>
            </div>
        </div>
        <!--<h3 class="heading text-center mb-5">What We Do</h3> -->
        <div class="row">
            <div class="col-lg-4 col-md-6 col-xs-12 mb-3">
                <div class=" card blog-block pt-2">
                    <img src="img/services/ac.png" class=" img-fluid card-img-top" style="height: 220px; min-height: 220px;">
                    <div class="card-block blog-content mt-2 py-2 text-center">
                        <h5 class="card-title">AC Service & Repair</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 mb-3">
                <div class=" card blog-block pt-2">
                    <img src="img/services/washingmachine.png" class=" img-fluid card-img-top" style="height: 220px; min-height: 220px;">
                    <div class="card-block blog-content mt-2 py-2 text-center">
                        <h5 class="card-title">Washing Machine Service & Repair</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 mb-3">
                <div class=" card blog-block pt-2">
                    <img src="img/services/fridge.png" class=" img-fluid card-img-top" style="height: 220px; min-height: 220px;">
                    <div class="card-block blog-content mt-2 py-2 text-center">
                        <h5 class="card-title">Refrigrator Repair</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 mb-3">
                <div class=" card blog-block pt-2">
                    <img src="img/services/gyser.png" class=" img-fluid card-img-top" style="height: 220px; min-height: 220px;">
                    <div class="card-block blog-content mt-2 py-2 text-center">
                        <h5 class="card-title">Gyser Service & Repair</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 mb-3">
                <div class=" card blog-block pt-2">
                    <img src="img/services/ro.png" class=" img-fluid card-img-top" style="height: 220px; min-height: 220px;">
                    <div class="card-block blog-content mt-2 py-2 text-center">
                        <h5 class="card-title">R.O. Water Service & Repair</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 mb-3">
                <div class=" card blog-block pt-2">
                    <img src="img/services/cctv.png" class=" img-fluid card-img-top" style="height: 220px; min-height: 220px;">
                    <div class="card-block blog-content mt-2 py-2 text-center">
                        <h5 class="card-title">CCTV Repair & Installation</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Form Start -->
<div class="contact-form-page">
    <div class="form-head">
        <div class="header-btn">
            <a class="top-btn" href="#"><i class="fa fa-times"></i></a>
        </div>
    </div>
    <h1 class="text-center">Please fill the form - I will response as fast as I can!</h1>
    <form method="post" action="{{route('submit.customer.query')}}">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control"  placeholder="Enter Your Name" required name="name">
        </div>
        <div class="form-group">
            <input type="phone" class="form-control"  placeholder="Enter Your Mobile" required name="mobile">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" placeholder="Enter Your Email" required name="email">
        </div>
        <div class="form-group">
            <textarea class="form-control" rows="2"  required="required" required placeholder="Write requirement details" name="description"></textarea>
        </div>
        <button type="submit" class="submit-buttom btn-block">Send</button>
    </form>
</div>
<a class="buttom-btn" href="#"><i class="fa fa-envelope"></i></a>
<!-- Contact Form End -->
<section class="bg-blms py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="heading text-center">Download Our App : <img src="img/playstore.png" style="width:200px; height:auto;"></h2>
            </div>
        </div>
    </div>
</section>
<!-- Footer Starts -->
<footer class="footer pt-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-text text-center">
                    <p class="mb-3">Copyright @2020, Zapaak Home Services. </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer ends -->

<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>

</html>
