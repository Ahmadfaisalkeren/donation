import Swiper, { EffectCoverflow, Navigation, Pagination } from 'swiper';

Swiper.use([EffectCoverflow, Navigation, Pagination]);

const swiper = new Swiper('.swiper', {
  navigation: {
    prevEl: '.button-prev',
    nextEl: '.button-next',
  },
  pagination: {
    clickable: true,
  },
  speed: 1000,
  slidesPerView: 'auto',
  centeredSlides: true,
  effect: 'coverflow',
  coverflowEffect: {
    rotate: 50,
    stretch: 0,
    depth: 100,
    modifier: 1,
    slideShadows: true,
  },
});
