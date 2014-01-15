var user = {
  admin : false,
  changePassword : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=user-change-password&source=app&email=' + localStorage.getItem('email') + '&old-password=' + $('#old-password').val() + '&password1=' + $('#password1').val() + '&password2=' + $('#password2').val(), 'user.changePassword');
    } else {
      if (response.result === 'success') {
        alert('Password successfully changed!');
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    }
  },
  checkLogin : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=login-app-check&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token'), 'user.checklogin');
    } else {
      if (response.result === 'success') {
        window.location = 'public/livechatter.html';
      } else {
        window.location = 'index.html';
      }
    }
  },
  getAccountInfo : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=user-account-info&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token'), 'user.getAccountInfo');
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
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=login&source=app&email=' + $('#email').val() + '&password=' + $('#password').val(), 'user.login');
    } else {
      if (response.result === 'success') {
        localStorage.setItem("user-id", response['user-id']);
        localStorage.setItem("user-token", response['user-token']);
        localStorage.setItem("email", response['email']);
        localStorage.setItem("firstname", response['firstname']);
        localStorage.setItem("lastname", response['lastname']);
        localStorage.setItem("alert-count", response['alert-count']);
        if (response['merchant-admin']) {
          this.admin = true;
          localStorage.setItem("member-since", response['memeber-since']);
          localStorage.setItem("merchant-token", response['merchant-token']);
          localStorage.setItem("merchant-name", response['merchant-name']);
          localStorage.setItem("merchant-logo", response['merchant-logo']);
          localStorage.setItem("chitchat-count", response['chitchat-count']);
          transition('admin/home.html');
        } else {
          transition('public/livechatter.html');
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
  setfirstname : function() {
    $('#nav-firstname').html(localStorage.getItem('firstname'));
  },
  signup : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=signup&source=app&firstname=' + $('#firstname').val() + '&lastname=' + $('#lastname').val() + '&email=' + $('#email').val() + '&password1=' + $('#password1').val() + '&password2=' + $('#password2').val(), 'user.signup');
    } else {
      if (response.result === 'success') {
        alert('Thank you for signing up to FancyChatter!');
        transition('index.html');
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
