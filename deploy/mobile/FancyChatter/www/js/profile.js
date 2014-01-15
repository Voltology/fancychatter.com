var profile = {
  id : null,
  getfeed : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=getfeed&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token'), 'profile.getfeed');
    } else {
      if (response.result === 'success') {
        var feed = response.feed;
        if (feed.length === 0) {
          $('#recent-activity-table').html('<tr><td align="center"><strong>You have no recent activity.</strong></td></tr>');
        } else {
          var html = '<tr><td width="60"></td><td></td></tr>';
          $.each(feed, function(key, value) {
            switch (value.type) {
              case 'alert':
                html += '<tr style="background-color: #fff;" class="livechatter-results-row"><td valign="top" colspan="2">';
                html += '<span style="font-size: 13px;">' + value.body + '</span></td></tr>';
                break;
              case 'chitchat':
                html += '<tr style="background-color: #fff;" class="livechatter-results-row"><td valign="top"><div style="overflow: hidden; width: 60px;">';
                html += '<img src="' + HOSTNAME + '/uploads/profile/' + value.profile_img + '" style="margin: 0;width: 100%;" /></div></td>';
                html += '<td valign="top" style="font-size: 13px;"><strong>' + localStorage.getItem('firstname') + ' ' + localStorage.getItem('lastname') + '</strong><br />';
                html += '<span style="font-style: italic; font-size: 12px; color: #aaa;">Sent to ' + value.category + ' within ' + value.distance + ' miles of ' + value.location + '</span>';
                html += '<br /><span style="font-size: 13px;">' + value.body + '</span></td></tr>';
                break;
              case 'post':
                html += '<tr style="background-color: #fff;" class="livechatter-results-row"><td valign="top"><div style="overflow: hidden; width: 60px;">';
                html += '<img src="' + HOSTNAME + '/uploads/profile/' + value.profile_img + '" style="margin: 0;width: 100%;" /></div></td>';
                html += '<td valign="top" style="font-size: 13px;"><strong>' + value.firstname + ' ' + value.lastname  + '</strong><br />';
                html += '<span style="font-size: 13px;">' + value.body + '</span></td></tr>';
                break;
            }
          });
          $('#recent-activity-table').html(html);
        }
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    }
  },
  getmerchant : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=getmerchant&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token'), 'profile.getuser');
    } else {
      if (response.result === 'success') {
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    }
  },
  getuser : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=getuser&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token'), 'profile.getuser');
    } else {
      if (response.result === 'success') {
        var user = response.user;
        $('#profile-image').attr('src', HOSTNAME + '/uploads/profile/' + user.profile_img);
        $('#profile-name').html(user.firstname + ' ' + user.lastname);
        $('#profile-location').html(user.city + ', ' + user.state.toUpperCase());
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    }
  }
};
