var profile = {
  autocomplete : function() {
    $searchfield = $('#search-field');
    ajax.get('api.php', '&a=autocomplete-profile&search=' + $searchfield.val(), function(response) {
      if (response.result === 'success') {
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
        var count = 0;
        $.each(response.results, function(key, value) {
          var img = (value.profile_img) ? value.profile_img : 'default.png';
          $autocompletebox.append('<div class="search-result" id="search-result-' + key + '" style="padding: 3px 5px; cursor: pointer;"><div style="display: inline-block; height: 36px; width: 36px; overflow: hidden;"><img src="/uploads/profile/' + img + '" style="width: 100%;" /></div> ' + value.firstname + ' ' + value.lastname +' <span style="font-size: 12px;">(' + value.city + ', ' + value.state + ')</span></div>');
          $result = $('#search-result-' + key);
          $result.on('click', function() {
            $autocompletebox.css('display', 'none');
            document.location = '/profile?id=' + value.id;
          });
          count++;
        });
        if (count === 0) {
          $autocompletebox.append('<div style="padding: 3px 5px; text-align: center;">No results found<br /><a href="/profile?a=invite">Invite a friend to FancyChatter</a></div>');
        } 
      }
    });
  }
};
