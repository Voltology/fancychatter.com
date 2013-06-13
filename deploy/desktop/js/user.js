var user = {
  login : function() {
    ajax.get('api.php', '&a=login&email=' + $('#email').val() + '&password=' + $('#password').val(), function(response) {
      if (response.result === 'success') {
        if ($('#search-wall').val() === 'true') {
          livechatter.search();
        } else {
          document.location = './';
        }
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    });
  },
  logout : function() {
    ajax.get('api.php', '&action=logout', function(response) {
      if (json.result === 'success') {
      } else {
      }
    });
  },
  signup : function(email, password1, password2, firstname, lastname) {
    ajax.get('api.php', '&a=signup&email=' + email + '&password1=' + password1 + '&password2=' + password2 + '&firstname=' + firstname + '&lastname=' + lastname, function(response) {
      if (response.result === 'success') {
        if ($('#search-wall').val() === 'true') {
          livechatter.search();
        } else {
          document.location = './';
        }
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    });
  }
};
