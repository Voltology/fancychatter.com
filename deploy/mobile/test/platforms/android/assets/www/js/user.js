var user = {
  login : function(response) {
    if (response == null) {
      ajax('http://fancychatter/api.php?a=login-app&email=' + $('#email').val() + '&password=' + $('#password').val(), 'user.login');
    } else {
      if (response.result === 'success') {
        transition('search.html');
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    }
  },
  signup : function(response) {
    if (response == null) {
      ajax('http://fancychatter/api.php?a=signup&firstname=' + $('#firstname').val() + '&lastname=' + $('#lastname').val() + '&email=' + $('#email').val() + '&password1=' + $('#password1').val() + '&password2=' + $('#password2').val(), 'user.signup');
    } else {
      if (response.result === 'success') {
        alert('Thank you for signing up to FancyChatter!');
        transition('login.html');
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

