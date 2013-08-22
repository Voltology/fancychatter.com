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
            var html = '<div class="search-result" id="search-result-' + key + '" style="padding: 3px 5px; cursor: pointer;"><div style="display: inline-block; height: 36px; width: 36px; overflow: hidden; vertical-align: middle;"><img src="/uploads/profile/' + img + '" style="width: 100%; vertical-align: middle;" /></div> <span style="font-size: 14px;">' + value.firstname + ' ' + value.lastname + '<span style="font-size: 12px;">';
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
            $autocompletebox.append('<div class="search-result" id="search-result-' + key + '" style="padding: 3px 5px; cursor: pointer;"><div style="display: inline-block; height: 36px; width: 36px; overflow: hidden; vertical-align: middle;"><img src="/uploads/logos/' + img + '" style="width: 100%;" /></div> <span style="font-size: 14px;">' + value.name + '</span> <span style="font-size: 12px;"> (' + value.city + ', ' + value.state + ')</span></div>');
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
        html += '<table cellpadding="2" cellspacing="0" width="100%" id="post-' + response.post.id + '" style="margin-top: 12px; position: relative;">';
        html += '<tr><td valign="top" width="60" rowspan=2"><div style="min-height: 8px; max-height: 60px; width: 60px; border: 1px solid #ccc; overflow: hidden;">';
        html += '<img src="/uploads/profile/' + response.post.profile_img + '" width: 100%; /></div></td>';
        html += '<td valign="top" colspan="2" style="padding-top: 4px;"><strong style="font-size: 14px; padding-left: 3px;">' + response.post.name + '</strong></td>'
        html += '<td align="right" valign="top" style="padding: 4px 30px 0 0;">' + response.post.timestamp + '<div style="position: absolute; top: 4px; right: 5px; cursor: pointer;" onclick="profile.removepost(' + response.post.id + ')"><i class="icon-remove-sign"></i></div></td></tr>';
        html += '<tr><td valign="top" colspan="3" style="border-bottom: 1px solid #ccc; font-size: 13px; padding-left: 5px">' + $('#postbox').val() + '</td></tr>';
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
