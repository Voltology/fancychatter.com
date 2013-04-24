var dialog = {
  close: function() {
  },
  open : function(type, header, height, width) {
    $('#dialog').css({
      'display' : 'block',
      'height' : height,
      'left' : ($(window).width() / 2) - (width / 2),
      'top' : ($(window).height() / 2) - (height / 2),
      'width' : width
    });
    $('#dialog-blanket').css('display', 'block');
    $('#dialog-header').html(header);
  },
  reposition : function() {
    $('#dialog').css({
      'left' : ($(window).width() / 2) - ($('#dialog').width() / 2),
      'top' : ($(window).height() / 2) - ($('#dialog').height() / 2)
    });
  }
};
