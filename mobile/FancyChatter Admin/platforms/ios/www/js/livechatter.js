var livechatter = {
  id : null,
  activate : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?a=livechatter-activate&s=admin-app&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password') + '&merchant-token=' + localStorage.getItem('merchant-token'), 'livechatter.activate');
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
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?a=livechatter-delete&s=admin-app&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password') + '&merchant-token=' + localStorage.getItem('merchant-token') + '&id=' + this.id, 'livechatter.delete');
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
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?a=livechatter-get&s=admin-app&merchant-token=' + localStorage.getItem('merchant-token') + '&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password'), 'livechatter.get');
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
  send : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?a=livechatter-send&s=admin-app&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password') + '&merchant-token=' + localStorage.getItem('merchant-token') + '&body=' + $('#livechatter-body').val() + '&startdate=' + $('#startdate').val() + '&starttime=' + $('#starttime').val() + '&enddate=' + $('#enddate').val() + '&endtime=' + $('#endtime').val(), 'livechatter.send');
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
