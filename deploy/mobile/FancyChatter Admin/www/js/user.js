var user = {
  checklogin : function(response) {
    if (response == null) {
      ajax('http://173.203.81.65/api.php?a=login-app-check&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password'), 'user.checklogin');
    } else {
      if (response.result === 'success') {
        window.location = 'home.html';
      } else {
        window.location = 'index.html';
      }
    }
  },
  login : function(response) {
    if (response == null) {
      ajax('http://173.203.81.65/api.php?a=login-app&email=' + $('#email').val() + '&password=' + $('#password').val(), 'user.login');
    } else {
      if (response.result === 'success') {
        localStorage.setItem("id", response.id);
        localStorage.setItem("email", response.email);
        localStorage.setItem("password", response.password);
        localStorage.setItem("firstname", response.firstname);
        localStorage.setItem("alert-count", response.alert_count);
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
  },
  signup : function(response) {
    if (response == null) {
      ajax('http://173.203.81.65/api.php?a=signup&firstname=' + $('#firstname').val() + '&lastname=' + $('#lastname').val() + '&email=' + $('#email').val() + '&password1=' + $('#password1').val() + '&password2=' + $('#password2').val(), 'user.signup');
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
