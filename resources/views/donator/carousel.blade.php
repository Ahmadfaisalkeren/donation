<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        @foreach ($carouselSlides as $item)
            <div class="swiper-slide carousel">
                <img src="{{ asset('storage/' . $item->image) }}" alt="">
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
</div>
