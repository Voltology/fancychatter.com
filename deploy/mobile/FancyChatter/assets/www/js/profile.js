var profile = {
  id : null,
  getfeed : function(response) {
    if (response == null) {
      ajax('http://173.203.81.65//api.php?a=getfeed&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password') + '&id=' + profile.id, 'profile.getfeed');
    } else {
      if (response.result === 'success') {
        var chitchats = response.feed.chitchats;
        if (chitchats.length === 0) {
          $('#recent-activity-table').html('<tr><td align="center"><strong>You have no recent activity.</strong></td></tr>');
        } else {
          var html = '<tr><td width="64"></td><td></td></tr>';
          $.each(chitchats, function(key, value) {
            html += '<tr style="background-color: #fff;" class="livechatter-results-row"><td valign="top"><div style="overflow: hidden; width: 60px;">';
            html += '<img src="http://173.203.81.65/uploads/profile/default.png" style="width: 100%;" /></div></td>';
            html += '<td valign="top"><strong>Chris Vuletich</strong><br />';
            html += '<span style="font-style: italic; font-size: 12px; color: #aaa;">Sent to ' + value.category + ' within ' + value.distance + ' miles of ' + value.location + '</span>';
            html += '<br /><span style="font-size: 13px;">' + value.body + '</span></td></tr>';
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
      ajax('http://173.203.81.65/api.php?a=getmerchant&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password') + '&id=' + profile.id, 'profile.getuser');
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
      ajax('http://173.203.81.65/api.php?a=getuser&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password') + '&id=' + profile.id, 'profile.getuser');
    } else {
      if (response.result === 'success') {
        var user = response.user;
        $('#profile-image').attr('src', 'http://173.203.81.65/uploads/profile/' + user.profile_img);
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
