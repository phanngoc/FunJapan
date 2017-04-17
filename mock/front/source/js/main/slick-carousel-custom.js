$(function() {
  // Carousel
  $(".regular").slick({
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: true,
    responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 5,
      }
    }, {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        arrows: false
      }
    }],
  });
});
