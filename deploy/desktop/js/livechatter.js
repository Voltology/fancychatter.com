var livechatter = {
  autocomplete : function() {
    $searchfield = $('#where');
    ajax.get('api.php', '&a=autocomplete-where&where=' + $searchfield.val(), function(response) {
      if (response.result === 'success') {
        $autocompletebox = $('#autocomplete-box');
        $autocompletebox.html('');
        $autocompletebox.css({
          'display' : 'block',
          'left' :  $searchfield.offset().left,
          'top' :  $searchfield.offset().top + 36,
          'width' :  $searchfield.width() + 12
        });
        if ($searchfield.val() === '') {
          $autocompletebox.css('display', 'none');
        }
        var count = 0;
        $.each(response.locations, function(key, value) {
          $autocompletebox.append('<div class="search-result" id="search-result-' + key + '" style="padding: 3px 5px; cursor: pointer;">' + value.location + '</div>');
          $result = $('#search-result-' + key);
          $result.on('click', function() {
            $searchfield.focus();
            $searchfield.val($(this).html());
            $autocompletebox.css('display', 'none');
          });
          count++;
        });
        if (count === 0) {
          $autocompletebox.append('<div style="padding: 3px 5px;">No results found</div>');
        } 
      }
    });
  },
  search : function() {
    if ($('#where').val() === '' || $('#what').val() === 'null' || $('#distance').val() === 'null') {
      alert('Make sure all search fields have been filled out');
    } else {
      $('#livechatter-search').submit();
    }
  }
};
