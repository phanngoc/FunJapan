$(function() {
  $('#show-comment-btn').click(function() {
    var commentModal = $('#comment-modal').find('.modal-content');
    if (commentModal.children().length == 0) {
      commentModal.append($('#comment-area-desktop').children().clone(true, true));
      commentModal.find('.list-group-header').css('display', 'none');
      commentModal.find('.hide-comment-modal').css('display', 'block');
    }
    $(this).parents().find('.show-comment-modal').css('display', 'none');

    $('#comment-modal').modal({
      backdrop: 'static',
      keyboard: false
    });
  });

  $('#hide-comment-btn').click(function() {
    $('.show-comment-modal').css('display', 'block');
    $('#comment-modal').modal('hide');
  });
});
