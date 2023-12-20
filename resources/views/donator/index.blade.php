<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Donator Page</title>

    @include('donator.components.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    @include('donator.navbar')

    @include('donator.carousel')

    @include('donator.donationCard')

    <div class="mt-5">
        <h3 class="text-center text-donker">What People Say About Us</h3>
        <div class="testiSwiper testimonialsSwiper">
            <div class="swiper-wrapper">
                @foreach ($testimonials as $item)
                    <div class="swiper-slide testimonials">
                        <div class="profile-image-container">
                            <img src="{{ asset('storage/' . $item->image) }}" class="profile-image">
                        </div>
                        <div class="testimonial-content">
                            <p class="testimonial-text">"{{ $item->testimonial }}"</p>
                            <p class="testimonial-name">{{ $item->name }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <footer class="bg-donker text-light text-center mt-5">
        <div class="container">
            <div class="row">
                <!-- Menu -->
                <div class="col-lg-4">
                    <h3>Menu 1</h3>
                    <ul>
                        <li><a href="#">Item 1</a></li>
                        <li><a href="#">Item 2</a></li>
                        <li><a href="#">Item 3</a></li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h3>Menu 2</h3>
                    <ul>
                        <li><a href="#">Item 4</a></li>
                        <li><a href="#">Item 5</a></li>
                        <li><a href="#">Item 6</a></li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h3>Menu 3</h3>
                    <ul>
                        <li><a href="#">Item 7</a></li>
                        <li><a href="#">Item 8</a></li>
                        <li><a href="#">Item 9</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Additional Footer Content -->
        <p class="mb-0">&copy; 2023 beWise Company</p>
    </footer>

    @include('donator.components.scripts')
</body>

</html>
