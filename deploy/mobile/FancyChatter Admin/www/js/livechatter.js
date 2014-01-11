var livechatter = {
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
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?a=livechatter-delete&s=admin-app&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password') + '&merchant-token=' + localStorage.getItem('merchant-token'), 'livechatter.delete');
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
  get : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?a=livechatter-get&s=admin-app&merchant-token=' + localStorage.getItem('merchant-token') + '&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password'), 'livechatter.get');
    } else {
      if (response.result === 'success') {
        var $container = $('#livechatter-active');
        $.each(response.livechatter, function(key, value) {
          var html = '<p>' + value.body + '</p>';
          html += '<!--<i class="icon-pencil"> <a href="#" onclick="">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;--><i class="icon-play"> <a href="#" onclick="livechatter.activate(' + value.id + ')">Activate</a>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="icon-remove"></i> <a href="#" onclick="livechatter.delete(' + value.id + ')">Delete</a><br />';
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
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?a=livechatter-send&s=admin-app&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password') + '&merchant-token=' + localStorage.getItem('merchant-token'), 'livechatter.send');
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
  }
}
