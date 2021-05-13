$(function() {

    $('#rec-slick').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        autoplay: true,
        speed: 1000,
        autoplaySpeed: 5000,
        arrows: false,
        centerMode: true,
        centerPadding: '100px',
          responsive: [
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerPadding: 0,
              }
            },
          ]
      });

});

$(function() {
  $(".nav-btn").on("click", function() {
    $(this).toggleClass("-active");
    $("#nav").toggleClass("-active");

  });
});

$(function() {
  $(".js-accodion").on("click", function() {
    $(this).next().slideToggle();
  });
});

$(function(){
  new WOW().init();
});