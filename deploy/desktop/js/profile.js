var profile = {
  autocomplete : function() {
    $searchfield = $('#search-field');
    $autocompletebox = $('#autocomplete-box');
    $autocompletebox.html('');
    $autocompletebox.css({
      'display' : 'block',
      'left' :  $searchfield.offset().left,
      'top' :  $searchfield.offset().top + 36,
      'width' :  $searchfield.width() + 15
    });
    if ($searchfield.val() === '') {
      $autocompletebox.css('display', 'none');
    }
    for(var i = 0; i < 6; i++) {
      $autocompletebox.append('<div class="search-result" style="padding: 3px 5px; cursor: pointer;">Test</div>');
    }
  }
};
