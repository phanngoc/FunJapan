$(function() {
  var show_more_btn = $(".show-more");
  var is_open = false;

  show_more_btn.on('click', function(e) {
    e.preventDefault();
    var hidden_categories = $('.hidden-category');
    var indicatior = $('.indicator');

    if (!is_open) {
      $(this).text('show less');
      hidden_categories.removeClass('hidden');
      indicatior.removeClass('fa-angle-double-right');
      indicatior.addClass('fa-angle-double-left');
      is_open = true;
    } else {
      $(this).text('show more');
      hidden_categories.addClass('hidden');
      indicatior.removeClass('fa-angle-double-left');
      indicatior.addClass('fa-angle-double-right');
      is_open = false;
    }
  });
});
