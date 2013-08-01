var profile = {
  activatesearch : function(id) {
    ajax.get('api.php', '&a=activatesearch&id=' + id, function(response) {
      $('#saved-search-' + id).attr('onclick', '').unbind('click');
      $('#saved-search-' + id).on('click', function() {
        profile.inactivatesearch(id);
      });
    });
  },
  inactivatesearch : function(id) {
    ajax.get('api.php', '&a=inactivatesearch&id=' + id, function(response) {
      $('#saved-search-' + id).attr('onclick', '').unbind('click');
      $('#saved-search-' + id).on('click', function() {
        profile.activatesearch(id);
      });
    });
  },
  autocomplete : function() {
    var $searchfield = $('#search-field');
    ajax.get('api.php', '&a=autocomplete-profile&search=' + $searchfield.val(), function(response) {
      if (response.result === 'success') {
        var $autocompletebox = $('#autocomplete-box');
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
          if (value.type === 'user') {
            var img = (value.profile_img) ? value.profile_img : 'default.png';
            var html = '<div class="search-result" id="search-result-' + key + '" style="padding: 3px 5px; cursor: pointer;"><div style="display: inline-block; height: 36px; width: 36px; overflow: hidden;"><img src="/uploads/profile/' + img + '" style="width: 100%;" /></div> ' + value.firstname + ' ' + value.lastname +' <span style="font-size: 12px;">';
            if (value.city && value.state) {
              html += '(' + value.city + ', ' + value.state + ')';
            } else if (value.city || value.state) {
              html += '(' + value.city + value.state + ')';
            }
            html += '</span></div>';
            $autocompletebox.append(html);
            $result = $('#search-result-' + key);
            $result.on('click', function() {
              $autocompletebox.css('display', 'none');
              document.location = '/profile?id=' + value.id;
            });
          } else if (value.type === 'merchant') {
            var img = (value.logo) ? value.logo : 'default.png';
            $autocompletebox.append('<div class="search-result" id="search-result-' + key + '" style="padding: 3px 5px; cursor: pointer;"><div style="display: inline-block; height: 36px; width: 36px; overflow: hidden;"><img src="/uploads/logos/' + img + '" style="width: 100%;" /></div> ' + value.name + '<span style="font-size: 12px;"> (' + value.city + ', ' + value.state + ')</span></div>');
          $result = $('#search-result-' + key);
          $result.on('click', function() {
            $autocompletebox.css('display', 'none');
            document.location = '/profile?mid=' + value.id;
          });
          }
          count++;
        });
        if (count === 0) {
          $autocompletebox.append('<div style="padding: 3px 5px; text-align: center;">No results found<br /><a href="/profile?a=invite">Invite a friend to FancyChatter</a></div>');
        }
      }
    });
  },
  post : function(id) {
    var $container = $('#interactions');
    var html = '';
    if ($('#postbox').val() !== '') {
      ajax.get('api.php', '&a=post&id=' + id + '&msg=' + $('#postbox').val(), function(response) {
        html += '<table cellpadding="0" cellspacing="0" width="100%">';
        html += '<tr><td valign="top" width="90" rowspan=2" style="padding: 6px;""><div style="min-height: 8px; max-height: 80px; width: 80px; border: 1px solid #ccc; overflow: hidden;">';
        html += '<img src="/uploads/profile/' + response.post.profile_img + '" width: 100%; /></div></td>';
        html += '<td valign="top" colspan="2" style="padding: 6px 0 0 6px;"><strong>' + response.post.name + '</strong></td>'
        html += '<td valign="top" align="right" style="color: #666; padding-top: 6px">' + response.post.timestamp + ' <i class="icon-remove-sign"></i></td></tr>';
        html += '<tr><td valign="top" colspan="3" style="border-bottom: 1px solid #ccc; padding-left: 6px">' + $('#postbox').val() + '</td></tr>';
        html += '</table>';
        $container.prepend(html);
        $('#postbox').val('');
        $('#no-interactions').remove();
      });
    }
  },
  removepost : function(id) {
    ajax.get('api.php', '&a=removepost&id=' + id, function(response) {
      $('#post-' + id).fadeOut(500, function() {
        $(this).remove();
      });
    });
  },
  removesearch : function (id) {
    ajax.get('api.php', '&a=removesearch&id=' + id, function(response) {
      $('#saved-search-box-' + id).fadeOut(500, function() {
        $(this).remove();
      });
    });
  }
};
