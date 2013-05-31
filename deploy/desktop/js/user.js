var user = {
  login : function() {
    ajax.get(API_URL, '&action=login&email=' + $('#email').val() + '&password=' + $('#password').val(), function(json) {
      if (json.result === 'success') {
        document.location = '/home';
      } else {
        alert('error');
      }
    });
  },
  logout : function() {
    ajax.get(API_URL, '&action=logout', function(json) {
      if (json.result === 'success') {
      } else {
      }
    });
  },
  signup : function(email, password1, password2, firstname, lastname) {
    ajax.get(API_URL, '&action=signup', function(response) {
      if (response.result === 'success') {
        document.location = './';
      } else {
        alert('error');
      }
    });
  }
};
