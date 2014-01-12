var user = {
  checklogin : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION +'/api.php?a=login-app-check&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password'), 'user.checklogin');
    } else {
      if (response.result === 'success') {
        window.location = 'home.html';
      } else {
        window.location = 'index.html';
      }
    }
  },
  getAccountInfo : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?a=user-account-info&s=admin-app&user-token=' + localStorage.getItem('user-id') + ' &email=' + $('#email').val() + '&password=' + $('#password').val(), 'user.getAccountInfo');
    } else {
      if (response.result === 'success') {
        var $container = $('#account-container');
        var html = '<table cellpadding="2" cellspacing="0" border="0">';
        html += '<tr>';
        html += '<td class="label">First Name</td>';
        html += '<td>' + localStorage.getItem('firstname') + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td class="label">Last Name</td>';
        html += '<td>' + localStorage.getItem('lastname') + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td valign="top" class="label">Account</td>';
        html += '<td>' + localStorage.getItem('merchant-name') + '<br />'
        html += '<div class="image-placeholder"><img src="http://www.fancychatter.com/uploads/logos/' + localStorage.getItem('merchant-logo') + '"></div>';
        html += '</td>';
        html += '</tr>';
        /*
        html += '<tr>';
        html += '<td class="label">Member Since</td>';
        html += '<td>' + localStorage.getItem('member-since') + '<br />'
        html += '</tr>';
        */
        html += '</table>';
        $container.html(html);
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    }
  },
  login : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?a=login&s=admin-app&email=' + $('#email').val() + '&password=' + $('#password').val(), 'user.login');
    } else {
      if (response.result === 'success') {
        localStorage.setItem("id", response.id);
        localStorage.setItem("email", response.email);
        localStorage.setItem("password", response.password);
        localStorage.setItem("user_token", response.token);
        localStorage.setItem("firstname", response.firstname);
        localStorage.setItem("lastname", response.lastname);
        localStorage.setItem("member-since", response['memeber-since']);
        localStorage.setItem("merchant-token", response['merchant-token']);
        localStorage.setItem("merchant-name", response['merchant-name']);
        localStorage.setItem("merchant-logo", response['merchant-logo']);
        localStorage.setItem("alert-count", response.alert_count);
        localStorage.setItem("chitchat-count", response.chitchat_count);
        transition('home.html');
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    }
  },
  setfirstname : function() {
    $('#nav-firstname').html(localStorage.getItem('firstname'));
    $('#home-firstname').html(localStorage.getItem('firstname'));
  },
  update : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?a=user-update&s=admin-app&user-id=' + localStorage.getItem('user-id') + '&merchant-token=' + localStorage.getItem('merchant-token') + '&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password'), 'user.update');
    } else {
      if (response.result === 'success') {
        $('#alert-count').html(response.alert_count);
        $('#chitchat-count').html(response.chitchat_count);
        localStorage.setItem("alert-count", response.alert_count);
        localStorage.setItem("chitchat-count", response.chitchat_count);
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
