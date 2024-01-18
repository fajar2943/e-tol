<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>E-Tol</title>
    <!--
Template 2109 The Card
http://www.tooplate.com/view/2109-the-card
-->
    <!-- load CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600">
    <!-- Google web font "Open Sans" -->
    <link rel="stylesheet" href="{{asset('site')}}/css/bootstrap.min.css">
    <!-- https://getbootstrap.com/ -->
    <link rel="stylesheet" href="{{asset('site')}}/slick/slick.css">
    <link rel="stylesheet" href="{{asset('site')}}/slick/slick-theme.css">
    <link rel="stylesheet" href="{{asset('site')}}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{asset('site')}}/css/tooplate-style.css">
    <!-- Templatemo style -->

</head>

<body>
    <!-- Loader -->
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>

    <div class="tm-main-container">

        <div class="tm-top-container">
            <!-- Menu -->
            <nav id="tmNav" class="tm-nav">
                @if (!auth()->user())
                <a href="/login" class="btn btn-secondary my-3">Login</a>
                @else
                <a href="/logout" class="btn btn-secondary my-3">Logout</a>
                @endif
                <a class="tm-navbar-menu" id="menu" href="#">Menu</a>
                <ul class="tm-nav-links">
                    <li class="tm-nav-item active">
                        <a href="#" data-linkid="0" data-align="right" class="tm-nav-link">Intro</a>
                    </li>
                    @if (auth()->user())
                    <li class="tm-nav-item">
                        <a href="#" data-linkid="1" data-align="right" class="tm-nav-link">History</a>
                    </li>
                    <li class="tm-nav-item">
                        <a href="#" id="vehiclePage" data-linkid="2" data-align="middle" class="tm-nav-link">Vehicles</a>
                    </li>
                    <li class="tm-nav-item">
                        <a href="#" data-linkid="3" data-align="left" class="tm-nav-link">Topup</a>
                    </li>
                    @endif
                </ul>
            </nav>

            <!-- Site header -->
            <header class="tm-site-header-box tm-bg-dark">
                <h1 class="tm-site-title">E-Tol</h1>
                <p class="mb-0 tm-site-subtitle">Elektronik Tol</p>
            </header>
        </div>
        <!-- tm-top-container -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Site content -->
                    <div class="tm-content">

                        <!-- Section 0 Introduction -->
                        <section class="tm-section tm-section-0">

                            @if (Session::has('success'))
                            <div class="alert alert-danger" role="alert">
                                {{Session::get('success')}}
                            </div>
                            @endif
                            <h2 class="tm-section-title mb-3 font-weight-bold">Introduction</h2>
                            <div class="tm-textbox tm-bg-dark">
                                <p>Etiam eu nisl sit amet odio convallis feugiat. Nulla vitae dui quam. Maecenas rhoncus
                                    tortor varius urna
                                    rhoncus, ultricies consequat nulla posuere.</p>
                                <p class="mb-0">Please tell your friends about tooplate website for free HTML templates.
                                    This is 70% alpha background.</p>
                            </div>
                            <a href="#" class="tm-link">Read More</a>
                        </section>


                        @if (auth()->user())
                        <!-- Section 1 Vehicles -->
                        <section class="tm-section tm-section-1">
                            <div class="tm-textbox tm-textbox-2 tm-bg-dark">
                                <h2 class="tm-text-blue mb-4">Vehicles</h2>
                                <p class="mb-4">In convallis mauris pellentesque, sollicitudin libero sed, blandit
                                    ipsum. Cras venenatis consectetur tincidunt.</p>
                                <p class="mb-0">Pellentesque habitant morbi tristique senectus et netus et malesuada
                                    fames ac turpis egestas.</p>
                            </div>
                        </section>
                        <!-- Section 2 Work (Gallery) -->
                        <section class="tm-section tm-section-2 mx-auto">
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addVehicle">
                                    Add Vehicle
                                </button>
                            </div>
                            <div class="grid">
                                @foreach ($vehicles as $vehicle)
                                    <figure class="effect-goliath tm-gallery-item">
                                        <img src="{{$vehicle->fileUrl()}}" alt="Image 1" class="">
                                        <figcaption>
                                            <h2>{{$vehicle->name}}</h2>
                                            <p>{{$vehicle->number}} <br>
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#editVehicle{{$vehicle->id}}">
                                                    Edit
                                                </button>
                                                <a class="btn btn-warning" href="/vehicle/{{$vehicle->id}}/delete">Hapus</a>
                                            </p>
                                        </figcaption>
                                    </figure>  
                                    <!-- Modal Edit -->
                                    <div class="modal fade" style="text-align: left" id="editVehicle{{$vehicle->id}}" tabindex="-1" aria-labelledby="editVehicleLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-dark" id="editVehicleLabel">Edit Vehicle</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="/vehicle/{{$vehicle->id}}" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body text-dark">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="id" value="{{$vehicle->id}}">
                                                        <div class="form-group">
                                                            <label for="name">Name</label>
                                                            <input type="text" name="name" value="{{(old('id') == $vehicle->id) ? old('name') : $vehicle->name}}"
                                                                class="form-control" placeholder="nama vehicle">
                                                            @if(old('id') == $vehicle->id && $errors->has('name'))
                                                                <span class="invalid-text text-danger">{{ $errors->first('name') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="number">Plat Number</label>
                                                            <input type="text" name="number" value="{{(old('id') == $vehicle->id) ? old('number') : $vehicle->number}}"
                                                                class="form-control" placeholder="plat number">
                                                            @if(old('id') == $vehicle->id && $errors->has('number'))
                                                                <span class="invalid-text text-danger">{{ $errors->first('number') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="image">Image</label><br>
                                                            <input type="file" name="image">
                                                            @if(old('id') == $vehicle->id && $errors->has('number'))
                                                                <span class="invalid-text text-danger">{{ $errors->first('number') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>                                  
                                @endforeach
                            </div>
                        </section>

                        <!-- Section 3 Contact -->
                        <section class="tm-section tm-section-3 tm-section-left">
                            <form action="/topup" class="tm-contact-form" method="post">
                                @csrf
                                <div class="form-group mb-4">
                                    <input type="number" name="total" class="form-control"
                                        placeholder="Total Topup" required />
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn tm-send-btn tm-fl-right">Topup Sekarang</button>
                                </div>
                            </form>
                        </section>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="tm-bottom-container">
            <!-- Barcode -->
            <div class="tm-barcode-box">
                <img src="{{asset('site')}}/img/bar-code.jpg" alt="Bar code">
            </div>

            <!-- Footer -->
            <footer>
                || Copyright &copy; 2018 Company Name

                || design: <a rel="nofollow" href="http://tooplate.com" class="tm-footer-link">tooplate</a>

                || distribution: <a href="https://themewagon.com" class="tm-footer-link">themewagon</a> ||
            </footer>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addVehicle" tabindex="-1" aria-labelledby="addVehicleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="addVehicleLabel">Add Vehicle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/vehicle" method="post" enctype="multipart/form-data">
                    <div class="modal-body text-dark">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{(old('id')) ? '' : old('name')}}" class="form-control" id="name"
                                placeholder="nama vehicle">
                            @if(!old('id') && $errors->has('name'))
                                <span class="invalid-text text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="number">Plat Number</label>
                            <input type="text" name="number" value="{{(old('id')) ? '' : old('number')}}" class="form-control" id="number"
                                placeholder="plat number">
                            @if(!old('id') && $errors->has('number'))
                                <span class="invalid-text text-danger">{{ $errors->first('number') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label><br>
                            <input type="file" name="image" placeholder="plat image">
                            @if(!old('id') && $errors->has('image'))
                                <span class="invalid-text text-danger">{{ $errors->first('image') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('site')}}/js/jquery-1.11.0.min.js"></script>
    <script src="{{asset('site')}}/js/background.cycle.js"></script>
    <script src="{{asset('site')}}/slick/slick.min.js"></script>
    <script src="{{asset('site')}}/js/jquery.magnific-popup.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let slickInitDone = false;
        let previousImageId = 0,
            currentImageId = 0;
        let pageAlign = "right";
        let bgCycle;
        let links;
        let eachNavLink;

        window.onload = function () {
            $('body').addClass('loaded');
        }

        function navLinkClick(e) {
            e.preventDefault();

            if ($(e.target).data("align")) {
                pageAlign = $(e.target).data("align");
            }

            // Change bg image
            previousImageId = currentImageId;
            currentImageId = $(e.target).data("linkid");
            bgCycle.cycleToNextImage(previousImageId, currentImageId);

            // Change menu item highlight
            $(`.tm-nav-item:eq(${previousImageId})`).removeClass('active');
            $(`.tm-nav-item:eq(${currentImageId})`).addClass('active');

            // Change page content
            $(`.tm-section-${previousImageId}`).fadeOut(function (e) {
                $(`.tm-section-${currentImageId}`).fadeIn();
                // Gallery
                if (currentImageId === 2) {
                    setupSlider();
                }
            });

            adjustFooter();
        }

        $(document).ready(function () {

            // Set first page
            $('.tm-section').fadeOut(0);
            $('.tm-section-0').fadeIn();

            // Set Background images
            // https://www.jqueryscript.net/slideshow/Simple-jQuery-Background-Image-Slideshow-with-Fade-Transitions-Background-Cycle.html
            bgCycle = $("body").backgroundCycle({
                imageUrls: [
                    '{{asset("site")}}/img/photo-02.jpg',
                    '{{asset("site")}}/img/photo-03.jpg',
                    '{{asset("site")}}/img/photo-04.jpg',
                    '{{asset("site")}}/img/photo-05.jpg'
                ],
                fadeSpeed: 2000,
                duration: -1,
                backgroundSize: SCALING_MODE_COVER
            });

            eachNavLink = $('.tm-nav-link');
            links = $('.tm-nav-links');

            // "Menu" open/close
            if (links.hasClass('open')) {
                links.fadeIn(0);
            } else {
                links.fadeOut(0);
            }

            // Each menu item click
            eachNavLink.on('click', navLinkClick);

            $('.tm-navbar-menu').click(function (e) {

                if (links.hasClass('open')) {
                    links.fadeOut();
                } else {
                    links.fadeIn();
                }

                links.toggleClass('open');
            });

            // window resize
            $(window).resize(function () {

                // If current page is Gallery page, set it up
                if (currentImageId === 2) {
                    setupSlider();
                }

                // Adjust footer
                adjustFooter();
            });

            adjustFooter();

        }); // DOM is ready

        function adjustFooter() {
            const windowHeight = $(window).height();
            const topHeight = $('.tm-top-container').height();
            const middleHeight = $('.tm-content').height();
            let contentHeight = topHeight + middleHeight;

            if (pageAlign === "left") {
                contentHeight += $('.tm-bottom-container').height();
            }

            if (contentHeight > windowHeight) {
                $('.tm-bottom-container').addClass('tm-static');
            } else {
                $('.tm-bottom-container').removeClass('tm-static');
            }
        }

        function setupSlider() {
            let slidesToShow = 4;
            let slidesToScroll = 2;
            let windowWidth = $(window).width();

            if (windowWidth < 480) {
                slidesToShow = 1;
                slidesToScroll = 1;
            } else if (windowWidth < 768) {
                slidesToShow = 2;
                slidesToScroll = 1;
            } else if (windowWidth < 992) {
                slidesToShow = 3;
                slidesToScroll = 2;
            }

            if (slickInitDone) {
                $('.tm-gallery').slick('unslick');
            }

            slickInitDone = true;

            $('.tm-gallery').slick({
                dots: true,
                customPaging: function (slider, i) {
                    var thumb = $(slider.$slides[i]).data();
                    return `<a>${i + 1}</a>`;
                },
                infinite: true,
                prevArrow: false,
                nextArrow: false,
                slidesToShow: slidesToShow,
                slidesToScroll: slidesToScroll
            });

            // Open big image when a gallery image is clicked.
            $('.slick-list').magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        }

    </script>

    <script>
        $(document).ready(function () {
            @if(Session::has('success'))
                openPage('{{Session::get("page")}}');
                Swal.fire({
                    title: 'Sukses',
                    text: '{{Session::get("success")}}',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                });
            @endif

            @if(old("id"))
                let id = '{{old("id")}}';
                openPage('#vehiclePage');
                $('#editVehicle'+id).modal('show');
            @elseif($errors->any())
                openPage('#vehiclePage');
                $('#addVehicle').modal('show');
            @endif
        });

        function openPage(page){
            $('#menu').trigger('click');
            $(page).trigger('click');
        }
    </script>
</body>

</html>
