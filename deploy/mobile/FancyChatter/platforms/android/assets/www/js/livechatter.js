var livechatter = {
  id : null,
  activate : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=livechatter-activate&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token') + '&merchant-token=' + localStorage.getItem('merchant-token'), 'livechatter.activate');
    } else {
      if (response.result === 'success') {
        alert('yay');
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        if (response.logout == true) {
          system.deletesession();
        }
      }
    }
  },
  delete : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=livechatter-delete&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token') + '&merchant-token=' + localStorage.getItem('merchant-token') + '&id=' + this.id, 'livechatter.delete');
    } else {
      if (response.result === 'success') {
        $('#livechatter-' + this.id).remove();
        alert('LiveChatter Removed!');
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        if (response.logout == true) {
          system.deletesession();
        }
      }
    }
  },
  get : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=livechatter-get&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token') + '&merchant-token=' + localStorage.getItem('merchant-token'), 'livechatter.get');
    } else {
      if (response.result === 'success') {
        var $container = $('#livechatter-active');
        $.each(response.livechatter, function(key, value) {
          var html = '<div class="livechatter-container" id="livechatter-' + value.id + '">';
          html += '<p><strong>Message:</strong> ' + value.body + '</p>';
          html += '<p><strong>Start Date:</strong> ' + value.starttime + '</p>';
          html += '<p><strong>End Date:</strong> ' + value.endtime + '</p>';
          html += '<div class="livechatter-settings">';
          html += '<!--<i class="icon-pencil"> <a href="#" onclick="">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="icon-pause"> <a href="#" onclick="livechatter.activate(' + value.id + ')">Pause</a>&nbsp;&nbsp;|&nbsp;&nbsp;--><i class="icon-remove"></i> <a href="#" onclick="livechatter.setId(' + value.id + '); livechatter.delete()">Delete</a><br />';
          html += '</div>';
          html += '</div>';
          $container.append(html);
        });
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        if (response.logout == true) {
          system.deletesession();
        }
      }
    }
  },
  search : function(response) {
    if (response == null) {
      chitchat.distance = $('#distance').val();
      chitchat.category = $('#what').val();
      chitchat.location = $('#where').val();
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=livechatter&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token') + '&where=' + $('#where').val() + '&what=' + $('#what').val() + '&distance=' + $('#distance').val(), 'livechatter.search');
    } else {
      if (response.result === 'success') {
        if (response.livechatter.length === 0) {
          alert('Sorry, no LiveChatter was found for that search.');
        } else {
          var html = '<tr class="livechatter-results-header"><td width="72"></td><td><strong>Business Name/Message</strong></td><td width="90" align="right"><strong>Distance</strong></td></tr>';
          var count = 0;
          $.each(response.livechatter, function(key, value) {
            html += '<tr style="background-color: #fff;" class="livechatter-results-row"><td valign="top"><div style="overflow: hidden; width: 70px;">';
            html += '<a href="profile.html?mid=' + value.merchant_id + '"><img src="http://173.203.81.65//uploads/logos/' + value.logo + '" style="width: 100%;" /></a></div></td>';
            html += '<td valign="top"><strong><a href="profile.html?mid=' + value.merchant_id + '">' + value.merchant_name + '</a></strong><br />' + value.body + '</td>';
            html += '<td valign="top" align="right">' + Math.round(value.distance * 100) / 100 + ' miles</td></tr>';
            html += '<img src="http://fancychatter/uploads/logos/' + value.logo + '" />';
            count++;
          });
          $('#livechatter-search').fadeOut(300, function () {
            $('#livechatter-results').fadeIn(300);
            $('#livechatter-info').html('Found ' + count + ' results for ' + response.category_name + ' within ' + $('#distance').val() + ' miles of ' + $('#where').val());
            $('#livechatter-results-table').html(html);
          });
        }
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        if (response.logout == true) {
          //system.deleteSession();
        }
      }
    }
  },
  send : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=livechatter-send&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token') + '&merchant-token=' + localStorage.getItem('merchant-token') + '&body=' + $('#livechatter-body').val() + '&startdate=' + $('#startdate').val() + '&starttime=' + $('#starttime').val() + '&enddate=' + $('#enddate').val() + '&endtime=' + $('#endtime').val(), 'livechatter.send');
    } else {
      if (response.result === 'success') {
        var html = '<div class="livechatter-container" id="livechatter-' + this.id + '">';
        html += '<p><strong>Message:</strong> ' + $('#livechatter-body').val() + '</p>';
        html += '<p><strong>Start Date:</strong> ' + $('#startdate').val() + ' ' + $('#starttime').val() + '</p>';
        html += '<p><strong>End Date:</strong> ' + $('#enddate').val() + ' ' + $('#endtime').val() + '</p>';
        html += '<div class="livechatter-settings">';
        html += '<!--<i class="icon-pencil"> <a href="#" onclick="">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;--><i class="icon-pause"> <a href="#" onclick="livechatter.activate(' + this.id + ')">Pause</a>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="icon-remove"></i> <a href="#" onclick="livechatter.setId(' + this.id + '); livechatter.delete()">Delete</a><br />';
        html += '</div>';
        html += '</div>';
        $('#livechatter-body').val('');
        $('#startdate').val('');
        $('#starttime').val('');
        $('#enddate').val('');
        $('#endtime').val('');
        $('#livechatter-active').prepend(html);
        alert('LiveChatter sent!');
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        if (response.logout == true) {
          system.deletesession();
        }
      }
    }
  },
  setId : function(id) {
    this.id = id;
  }
}
